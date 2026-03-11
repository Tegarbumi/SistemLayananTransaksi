<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Carts;
use App\Models\Service;   // TAMBAHKAN INI
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request, $id, $userId)
    {
        $alat = Alat::findOrFail($id);

        $cart = new Carts();
        $cart->user_id = $userId;
        $cart->alat_id = $alat->id;
        $cart->harga = $alat->harga24;
        $cart->durasi = 24;

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