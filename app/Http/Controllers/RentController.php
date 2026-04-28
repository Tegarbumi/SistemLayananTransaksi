<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;

class RentController extends Controller
{
    // ================= PENYEWAAN AKTIF =================
    public function index() {

        $all = Payment::with(['user','order','dendas'])
                ->whereNotIn('status', [5]) 
                ->orderBy('id','DESC')
                ->get();

        $denda = $all->where('status', 4); 
        $normal = $all->whereIn('status', [1,2,3]); 

        $penyewaan = $denda->merge($normal);

        return view('admin.penyewaan.penyewaan',[
            'penyewaan' => $penyewaan,
        ]);
    }

    // ================= DETAIL =================
    public function detail($id) {
    $payment = Payment::with(['user','order.alat','dendas'])->findOrFail($id);

    // 
    $total = \App\Models\Order::where('payment_id', $payment->id)->sum('harga');

    return view('admin.penyewaan.detail',[
        'detail' => $payment->order,
        'total' => $total,
        'status' => $payment->status,
        'payment' => $payment,
    ]);
    }

    // ================= HAPUS =================
    public function destroy($id) {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect(route('penyewaan.index'));
    }

    // ================= RIWAYAT =================
    public function riwayat() {

        return view('admin.penyewaan.riwayat',[
            'penyewaan' => Payment::with(['user','order','dendas'])
                ->where('status', 5) // 
                ->orderBy('id','DESC')
                ->get()
        ]);
    }
}