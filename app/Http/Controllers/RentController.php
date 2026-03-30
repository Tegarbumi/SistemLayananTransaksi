<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;

class RentController extends Controller
{
    // ================= PENYEWAAN AKTIF =================
    public function index() {

        // 🔥 ambil semua kecuali selesai
        $all = Payment::with(['user','order','dendas'])
                ->whereNotIn('status', [5]) // hanya exclude selesai
                ->orderBy('id','DESC')
                ->get();

        // 🔥 pisahkan denda & normal
        $denda = $all->where('status', 4); // ada denda
        $normal = $all->whereIn('status', [1,2,3]); // normal

        // 🔥 gabungkan → denda di atas
        $penyewaan = $denda->merge($normal);

        return view('admin.penyewaan.penyewaan',[
            'penyewaan' => $penyewaan,
        ]);
    }

    // ================= DETAIL =================
    public function detail($id) {
        $payment = Payment::with(['user','order.alat','dendas'])->findOrFail($id);

        return view('admin.penyewaan.detail',[
            'detail' => $payment->order,
            'total' => $payment->total,
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
                ->where('status', 5) // 🔥 HANYA SELESAI
                ->orderBy('id','DESC')
                ->get()
        ]);
    }
}