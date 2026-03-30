<?php

namespace App\Http\Controllers;

use App\Mail\OrderAccepted;
use App\Mail\OrderPaid;
use App\Models\Carts;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Alat;
use App\Models\Denda;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{

    // ================= MEMBER =================
    public function show() {

    // 🔥 ambil semua payment user + relasi denda
    $payments = Payment::with(['user','order','dendas'])
                ->where('user_id', Auth::id())
                ->orderBy('id','DESC')
                ->get();

    // 🔥 pisahkan yang ada denda (status 4)
    $dendaAktif = $payments->where('status', 4);

    // 🔥 sisanya (bukan denda & bukan selesai)
    $reservasiNormal = $payments->whereNotIn('status',[4,5]);

    // 🔥 gabungkan → denda di atas
    $reservasi = $dendaAktif->merge($reservasiNormal);

    return view('member.reservasi',[
        'reservasi' => $reservasi,
        'riwayat' => $payments->whereIn('status',[5]) // selesai saja
    ]);
}

    public function detail($id) {

    $payment = Payment::with(['order','dendas'])
                ->findOrFail($id);

    if($payment->user_id != Auth::id()) {
        return abort(403, "Forbidden");
    }

    // ✅ HITUNG DENDA
    $totalDenda = $payment->dendas->sum('jumlah');

    // ✅ GRAND TOTAL
    $grandTotal = $payment->total + $totalDenda;

    return view('member.detailreservasi',[
        'detail' => $payment->order,
        'total' => $payment->total,
        'totalDenda' => $totalDenda,   // ⬅️ TAMBAHAN
        'grandTotal' => $grandTotal,   // ⬅️ TAMBAHAN
        'paymentId' => $payment->id,
        'paymentStatus' => $payment->status,
        'bukti' => $payment->bukti,
        'payment' => $payment          // ⬅️ biar akses denda di blade
    ]);
}

    // ================= CREATE ORDER =================
    public function create(Request $request) {

        $cart = Carts::where('user_id', Auth::id())->get();

        if($cart->isEmpty()){
            return back()->with('error','Keranjang kosong');
        }

        $pembayaran = Payment::create([
            'no_invoice' => Auth::id()."/".Carbon::now()->timestamp,
            'user_id' => Auth::id(),
            'total' => $cart->sum('harga')
        ]);

        $cartAlat = [];
        $start = date('Y-m-d H:i', strtotime($request['start_date']." ".$request['start_time']));

        foreach($cart as $c) {

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
                'payment_id' => $pembayaran->id,
                'durasi' => $c->durasi,
                'starts' => $start,
                'ends' => $end,
                'harga' => $c->harga,
            ]);

            $c->delete();
        }

        // ================= BONUS =================
        $bonusJumlah = floor($pembayaran->total / 500000);

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
                    'payment_id' => $pembayaran->id,
                    'durasi' => 0,
                    'starts' => $start,
                    'ends' => $start,
                    'harga' => 0,
                ]);
            }
        }

        return redirect(route('order.show'));
    }

    public function destroy($id) {
        Payment::findOrFail($id)->delete();
        return redirect(route('order.show'));
    }

    // ================= ACC RESERVASI =================
    public function acc(Request $request, $paymentId) {

        $orders = $request->order ?? [];
        $payment = Payment::findOrFail($paymentId);

        if(count($orders) > 0){
            Order::whereIn('id', $orders)->update(['status' => 2]);
        }

        Order::where('payment_id', $paymentId)
            ->where('status', 1)
            ->whereNotIn('id', $orders)
            ->update(['status' => 3]);

        $payment->update([
            'status' => 2,
            'total' => Order::where('payment_id', $paymentId)
                        ->where('status', 2)
                        ->sum('harga')
        ]);

        session()->flash('notif', 'Reservasi kamu telah disetujui!');

        try {
            Mail::to($payment->user->email)->send(new OrderAccepted($payment));
        } catch (\Exception $e) {}

        return back();
    }

    // ================= UPLOAD PEMBAYARAN =================
    public function bayar(Request $request, $id)
    {
        $request->validate([
            'bukti' => "required|image|mimes:png,jpg,jpeg|max:5000",
            'jaminan_ktp' => "required|image|mimes:png,jpg,jpeg|max:5000"
        ]);

        $payment = Payment::findOrFail($id);

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

    // ================= ACC PEMBAYARAN =================
    public function accbayar($id) {

        $payment = Payment::findOrFail($id);
        $payment->update(['status' => 3]);

        session()->flash('notif', 'Pembayaran kamu telah dikonfirmasi!');

        try {
            Mail::to($payment->user->email)->send(new OrderPaid($payment));
        } catch (\Exception $e) {}

        return back();
    }
    

    // ================= PENGEMBALIAN + DENDA =================
    public function alatkembali(Request $request, $id)
    {
        $payment = Payment::with('dendas')->findOrFail($id);

        if ($request->filled('denda') && $request->denda > 0) {

            if (!$payment->dendas()->exists()) {

                Denda::create([
                    'payment_id' => $payment->id,
                    'jenis_denda' => $request->jenis_denda ?: 'telat',
                    'jumlah' => $request->denda,
                    'keterangan' => $request->keterangan ?: '-',
                    'status_pembayaran' => 'belum_bayar'
                ]);
            }

            $payment->update(['status' => 4]);

        } else {

            $payment->update(['status' => 5]);
        }

        return back()->with('success', 'Pengembalian berhasil');
    }

    // ================= BAYAR DENDA =================
    public function bayarDenda(Request $request, $id)
    {
        $request->validate([
            'bukti_denda' => "required|image|mimes:png,jpg,jpeg|max:5000",
        ]);

        $payment = Payment::findOrFail($id);

        $filename = time().'_denda_'.$request->file('bukti_denda')->getClientOriginalName();
        $request->file('bukti_denda')->move(public_path('images/denda'), $filename);

        $payment->update([
            'bukti_denda' => $filename
        ]);

        return back()->with('success','Bukti pembayaran denda berhasil diupload');
    }

    // ================= ACC DENDA =================
    public function accDenda($id)
    {
        $payment = Payment::with('dendas')->findOrFail($id);

        foreach ($payment->dendas as $denda) {
            $denda->update([
                'status_pembayaran' => 'sudah_bayar'
            ]);
        }

        $payment->update(['status' => 5]);

        return back()->with('success', 'Denda berhasil dikonfirmasi');
    }
    
    

    // ================= LAPORAN =================
   public function cetak() {

    $laporan = DB::table('payments')
        ->leftJoin('dendas','dendas.payment_id','=','payments.id')
        ->join('users','users.id','=','payments.user_id')
        ->where('payments.status','>',2)
        ->select(
            'payments.id',
            'payments.no_invoice',
            'payments.total',
            'payments.created_at',
            'users.name',
            DB::raw('COALESCE(SUM(dendas.jumlah),0) as total_denda')
        )
        ->groupBy(
            'payments.id',
            'payments.no_invoice',
            'payments.total',
            'payments.created_at',
            'users.name'
        )
        ->orderBy('payments.id','DESC')
        ->get();

    // ambil detail item per transaksi
    foreach ($laporan as $item) {

        $item->items = DB::table('orders')
            ->leftJoin('alats','alats.id','=','orders.alat_id')
            ->leftJoin('services','services.id','=','orders.service_id')
            ->where('orders.payment_id', $item->id)
            ->select(
                'orders.harga',
                'alats.nama_alat',
                'services.nama_layanan'
            )
            ->get();
    }

    return view('admin.laporan',[
        'laporan' => $laporan
    ]);
}

// ||||||||||||||||| DASHBOARD GRAFIK|||||||||||||||||||
public function grafik()
{
    $data = DB::table('payments')
        ->leftJoin('dendas','dendas.payment_id','=','payments.id')
        ->where('payments.status','>',2)
        ->select(
            DB::raw('DATE(payments.created_at) as tanggal'),
            DB::raw('SUM(payments.total) as total_sewa'),
            DB::raw('COALESCE(SUM(dendas.jumlah),0) as total_denda')
        )
        ->groupBy(DB::raw('DATE(payments.created_at)'))
        ->orderBy('tanggal','ASC')
        ->get();

    return view('admin.grafik', compact('data'));
}

public function reject(Request $request, $paymentId)
{
    $orders = $request->order ?? [];

    if(count($orders) > 0){
        Order::whereIn('id', $orders)->update(['status' => 3]); // 3 = ditolak
    }

    return back()->with('success','Item berhasil direject');
}
}