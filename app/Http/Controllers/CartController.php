<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Carts;
use App\Models\Service;   
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request, $id, $userId)
    {
        $alat = Alat::findOrFail($id);

        // ambil durasi dari button
        $durasi = $request->btn ?? 24;

        if ($durasi == 24) {
            $harga = $alat->harga24;
        } elseif ($durasi == 48) {
            $harga = $alat->harga48 ?? ($alat->harga24 * 2);
        } elseif ($durasi == 72) {
            $harga = $alat->harga72 ?? ($alat->harga24 * 3);
        } else {
            $harga = $alat->harga24;
            $durasi = 24;
        }

        $cart = new Carts();
        $cart->user_id = $userId;
        $cart->alat_id = $alat->id;
        $cart->harga = $harga;
        $cart->durasi = $durasi;

        $cart->save();

        return back()->with('success', 'Berhasil ditambahkan ke keranjang');
    }

    public function destroy($id)
    {
        $cart = Carts::findOrFail($id);
        $cart->delete();

        return back();
    }

    public function storeService($id,$userId)
    {
        $service = Service::findOrFail($id);

        Carts::create([
            'user_id' => $userId,
            'service_id' => $service->id,
            'harga' => $service->harga,
            'durasi' => null
        ]);

        return back()->with('success','Layanan berhasil ditambahkan ke keranjang');
    }
}