<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Denda;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    public function store(Request $request, $paymentId)
    {
        $payment = Payment::findOrFail($paymentId);

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

        return redirect()->route('order.show')
            ->with('success','Denda berhasil ditambahkan');
    }

    public function bayarDenda(Request $request, $id)
    {
        $request->validate([
            'bukti_denda' => "required|image|mimes:png,jpg,jpeg|max:5000",
        ]);

        $payment = Payment::findOrFail($id);

        $filename = time().'_denda_'.$request->file('bukti_denda')->getClientOriginalName();
        $request->file('bukti_denda')->move(public_path('images/denda'), $filename);

        $payment->update(['bukti_denda' => $filename]);

        return back()->with('success','Upload denda berhasil');
    }

    public function accDenda($id)
    {
        $payment = Payment::with('dendas')->findOrFail($id);

        foreach ($payment->dendas as $denda) {
            $denda->update([
                'status_pembayaran' => 'sudah_bayar'
            ]);
        }

        $payment->update(['status' => 5]);

        return back()->with('success','Denda dikonfirmasi');
    }
}