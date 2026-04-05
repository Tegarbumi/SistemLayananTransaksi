<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class GrafikController extends Controller
{
    

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
}