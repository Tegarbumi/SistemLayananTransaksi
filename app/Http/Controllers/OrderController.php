<?php

namespace App\Http\Controllers;

use App\Mail\OrderAccepted;
use App\Mail\OrderPaid;
use App\Models\Carts;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Alat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{

    public function show() {
        $payment = Payment::with(['user','order'])->where('user_id', Auth::id());
        return view('member.reservasi',[
            'reservasi' => $payment->where('status','!=', 4)->orderBy('id','DESC')->get(),
            'riwayat' => Payment::with(['user','order'])->where('user_id', Auth::id())->where('status', 4)->orderBy('id','DESC')->get()
        ]);
    }

    public function detail($id) {
        $detail = Order::where('payment_id', $id)->get();
        $payment = Payment::find($id);

        if($payment->user_id == Auth::id()) {
            return view('member.detailreservasi',[
                'detail' => $detail,
                'total' => $payment->total,
                'paymentId' => $payment->id,
                'paymentStatus' => $detail->first()->payment->status,
                'bukti' => $payment->bukti
            ]);
        } else {
            return abort(403, "Forbidden");
        }
    }

    public function create(Request $request) {

        $cart = Carts::where('user_id', Auth::id())->get();

        $pembayaran = new Payment();
        $pembayaran->no_invoice = Auth::id()."/".Carbon::now()->timestamp;
        $pembayaran->user_id = Auth::id();
        $pembayaran->total = $cart->sum('harga');
        $pembayaran->save();

        $paymentId = $pembayaran->id;
        $cartAlat = [];

        foreach($cart as $c) {

            $start = date('Y-m-d H:i', strtotime($request['start_date']." ".$request['start_time']));

            if($c->alat_id) {
                $end = date('Y-m-d H:i', strtotime($start."+".$c->durasi." hours"));
                $cartAlat[] = $c->alat_id;
            } else {
                $end = $start;
            }

            Order::create([
                'alat_id' => $c->alat_id,
                'service_id' => $c->service_id,
                'user_id' => $c->user_id,
                'payment_id' => $paymentId,
                'durasi' => $c->durasi,
                'starts' => $start,
                'ends' => $end,
                'harga' => $c->harga,
            ]);

            $c->delete();
        }

        // ================= BONUS =================
        $bonusJumlah = floor($pembayaran->total / 200000);
        $bonusNama = [];

        if($bonusJumlah > 0){

            $availableAlat = Alat::whereNotIn('id',$cartAlat)
                                ->inRandomOrder()
                                ->take($bonusJumlah)
                                ->get();

            foreach($availableAlat as $bonusAlat){

                Order::create([
                    'alat_id' => $bonusAlat->id,
                    'service_id' => null,
                    'user_id' => Auth::id(),
                    'payment_id' => $paymentId,
                    'durasi' => 0,
                    'starts' => $start,
                    'ends' => $start,
                    'harga' => 0,
                ]);

                $bonusNama[] = $bonusAlat->nama_alat;
            }

            session()->flash('bonus_alat', $bonusNama);
        }

        return redirect(route('order.show'));
    }

    public function destroy($id) {
        Payment::find($id)->delete();
        return redirect(route('order.show'));
    }

    // ================= ACC =================
    public function acc(Request $request, $paymentId) {

        $orders = $request->order ?? [];
        $payment = Payment::find($paymentId);

        if(count($orders) > 0){
            foreach($orders as $o) {
                Order::where('id', $o)->update(['status' => 2]);
            }
        }

        Order::where('payment_id', $paymentId)
            ->where('status', 1)
            ->whereNotIn('id', $orders)
            ->update(['status' => 3]);

        $payment->update(['status' => 2]);

        $payment->update([
            'total' => Order::where('payment_id', $paymentId)
                ->where('status', 2)
                ->sum('harga')
        ]);

        // NOTIF POPUP
        session()->flash('notif', 'Reservasi kamu telah disetujui!');

        // EMAIL AMAN
        try {
            Mail::to($payment->user->email)->send(new OrderAccepted($payment));
        } catch (\Exception $e) {}

        return back();
    }

    public function bayar(Request $request, $id)
    {
        $this->validate($request, [
            'bukti' => "required|image|mimes:png,jpg,jpeg|max:5000",
            'jaminan_ktp' => "required|image|mimes:png,jpg,jpeg|max:5000"
        ]);

        $payment = Payment::find($id);

        $filename = time().'_bukti_'.$request->file('bukti')->getClientOriginalName();
        $request->file('bukti')->move(public_path('images/evidence'), $filename);

        $ktpname = time().'_ktp_'.$request->file('jaminan_ktp')->getClientOriginalName();
        $request->file('jaminan_ktp')->move(public_path('images/ktp'), $ktpname);

        $payment->update([
            'bukti' => $filename,
            'jaminan_ktp' => $ktpname
        ]);

        return back()->with('success','Upload berhasil');
    }

    public function accbayar($id) {

        $payment = Payment::find($id);
        $payment->update(['status' => 3]);

        // NOTIF POPUP
        session()->flash('notif', 'Pembayaran kamu telah dikonfirmasi!');

        try {
            Mail::to($payment->user->email)->send(new OrderPaid($payment));
        } catch (\Exception $e) {}

        return back();
    }

    public function alatkembali($id) {
        Payment::find($id)->update(['status' => 4]);
        return back();
    }

    public function cetak() {

        $laporan = DB::table('orders')
            ->join('payments','payments.id','orders.payment_id')
            ->join('alats','alats.id','orders.alat_id')
            ->join('users','users.id','orders.user_id')
            ->where('orders.status',2)
            ->where('payments.status','>',2)
            ->get(['*','orders.created_at AS tanggal']);

        return view('admin.laporan',[
            'laporan' => $laporan,
            'total' => $laporan->sum('harga')
        ]);
    }
}