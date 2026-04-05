<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
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
}