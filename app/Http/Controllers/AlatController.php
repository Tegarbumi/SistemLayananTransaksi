<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Category;
use App\Models\Carts;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index($id = null) {

        if($id != null) {
            $alats = Alat::where('kategori_id','=',$id)->get();
        }
        else {
            $alats = Alat::with(['category'])->get();
        }

        if(request('search')) {
            $key = request('search');
            $alats =  Alat::with(['category'])->where('nama_alat','LIKE','%'.$key.'%')->get();
        }

        return view('admin.alat.alat',[
            'alats' => $alats,
            'categories' => Category::all()
        ]);
    }

    public function edit($id) {
        $alat = Alat::with(['category'])->find($id);

        return view('admin.alat.editalat',[
            'alat' => $alat,
            'kategori' => Category::all()
        ]);
    }

    public function store(Request $request) {

        $this->validate($request,[
            'nama' => 'required',
            'kategori' => 'required',
            'harga24' => 'required|numeric',
            'harga48' => 'nullable|numeric',
            'harga72' => 'nullable|numeric',
            'gambar' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);

        $alat = new Alat();
        $alat->nama_alat = $request['nama'];
        $alat->deskripsi = $request['deskripsi'];
        $alat->kategori_id = $request['kategori'];
        $alat->harga24 = $request['harga24'];
        $alat->harga48 = $request['harga48'];
        $alat->harga72 = $request['harga72'];

        if($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $filename = time().'-'.$gambar->getClientOriginalName();
            $gambar->move(public_path('images'), $filename);
            $alat->gambar = $filename;
        }

        $alat->save();

        return redirect(route('alat.index'))->with('message', 'Alat berhasil ditambah!');
    }

    public function update(Request $request, $id) {

        $this->validate($request,[
            'nama' => 'required',
            'kategori' => 'required',
            'harga24' => 'required|numeric',
            'harga48' => 'nullable|numeric',
            'harga72' => 'nullable|numeric',
            'gambar' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);

        $alat = Alat::find($id);
        $alat->nama_alat = $request['nama'];
        $alat->deskripsi = $request['deskripsi'];
        $alat->kategori_id = $request['kategori'];
        $alat->harga24 = $request['harga24'];
        $alat->harga48 = $request['harga48'];
        $alat->harga72 = $request['harga72'];

        if($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $filename = time().'-'.$gambar->getClientOriginalName();
            $gambar->move(public_path('images'), $filename);
            $alat->gambar = $filename;
        }

        $alat->save();

        // ================= UPDATE CART =================

        // 24 JAM
        Carts::where('alat_id',$id)->where('durasi',24)->update([
            'harga' => $alat->harga24
        ]);

        // 48 JAM
        Carts::where('alat_id',$id)->where('durasi',48)->update([
            'harga' => $alat->harga48 ?? ($alat->harga24 * 2)
        ]);

        // 72 JAM
        Carts::where('alat_id',$id)->where('durasi',72)->update([
            'harga' => $alat->harga72 ?? ($alat->harga24 * 3)
        ]);

        return redirect(route('alat.index'))->with('message', 'Alat berhasil diperbarui!');
    }

    public function destroy($id) {

        $alat = Alat::find($id);

        if($alat->gambar != 'noimage.jpg') {
            $filepath = public_path('images'). '/' . $alat->gambar;
            unlink($filepath);
        }

        $payment = new Payment();
        $order = Order::where('alat_id', $id)->get();

        foreach($order as $o) {
            $payment->where('id', $o->payment_id)->decrement('total', $o->harga);
        }

        $alat->delete();

        return redirect(route('alat.index'))->with('message', 'Alat berhasil dihapus!');
    }
}