<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
     // ================= LAPORAN =================
    public function cetak()
    {
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

        return view('admin.laporan', compact('laporan'));
    }
}