<?php

namespace App\Http\Controllers;

use App\Mail\OrderAccepted;
use App\Mail\OrderPaid;
use App\Models\Carts;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Denda;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    protected OrderService $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    // ================= MEMBER =================
    public function show()
    {
        $payments = Payment::with(['user', 'order', 'dendas'])
            ->where('user_id', Auth::id())
            ->orderByDesc('id')
            ->get();

        $reservasi = $payments->where('status', 4)
            ->merge($payments->whereNotIn('status', [4, 5]));

        return view('member.reservasi', [
            'reservasi' => $reservasi,
            'riwayat' => $payments->whereIn('status', [5])
        ]);
    }

    public function detail($id)
    {
        $payment = Payment::with(['order', 'dendas'])->findOrFail($id);

        if ($payment->user_id != Auth::id()) {
            abort(403);
        }

        $totalDenda = $payment->dendas->sum('jumlah');
        $grandTotal = $payment->total + $totalDenda;

        return view('member.detailreservasi', [
            'detail' => $payment->order,
            'total' => $payment->total,
            'totalDenda' => $totalDenda,
            'grandTotal' => $grandTotal,
            'paymentId' => $payment->id,
            'paymentStatus' => $payment->status,
            'bukti' => $payment->bukti,
            'payment' => $payment
        ]);
    }

    // ================= CREATE ORDER =================
    public function create(Request $request)
    {
        $cart = Carts::where('user_id', Auth::id())->get();

        if ($cart->isEmpty()) {
            return back()->with('error', 'Keranjang kosong');
        }

        $this->service->createOrder($cart, Auth::id(), $request);

        return redirect()->route('order.show');
    }

    public function destroy($id)
    {
        Payment::findOrFail($id)->delete();
        return redirect()->route('order.show');
    }

    // ================= ACC RESERVASI =================
    public function acc(Request $request, $paymentId)
    {
        $orders = $request->order ?? [];
        $payment = Payment::findOrFail($paymentId);

        if (count($orders) > 0) {
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

        try {
            Mail::to($payment->user->email)->send(new OrderAccepted($payment));
        } catch (\Exception $e) {
            // silent fail
        }

        return back();
    }

    // ================= ACC PEMBAYARAN =================
    public function accbayar($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update(['status' => 3]);

        try {
            Mail::to($payment->user->email)->send(new OrderPaid($payment));
        } catch (\Exception $e) {
        }

        return back();
    }

    // ================= PENGEMBALIAN =================

public function alatkembali(Request $request, $id)
{
    $payment = Payment::findOrFail($id);

    if ($request->filled('denda') && $request->denda > 0) {

        // kalau belum ada denda
        if (!$payment->dendas()->exists()) {
            Denda::create([
                'payment_id' => $payment->id,
                'jenis_denda' => $request->jenis_denda ?? 'telat',
                'jumlah' => $request->denda,
                'keterangan' => $request->keterangan ?? '-',
                'status_pembayaran' => 'belum_bayar'
            ]);
        }

        $payment->update(['status' => 4]);

        return back()->with('success', 'Pengembalian dengan denda');

    } else {

        $payment->update(['status' => 5]);

        return back()->with('success', 'Pengembalian tanpa denda');
    }
}
    public function reject(Request $request, $paymentId)
    {
        $orders = $request->order ?? [];

        if (count($orders) > 0) {
            Order::whereIn('id', $orders)->update(['status' => 3]);
        }

        return back()->with('success', 'Item berhasil direject');
    }
}