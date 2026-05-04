<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{

    // =========================
    // LIST LAYANAN
    // =========================
    public function index()
    {
        $services = Service::latest()->get();

        return view('admin.service.layanan', [
            'services' => $services
        ]);
    }

    public function customerIndex()
{
    $services = Service::all();
    return view('customer.services', compact('services'));
}


    // =========================
    // TAMBAH LAYANAN
    // =========================
    public function store(Request $request)
    {

        $request->validate([
            'nama_layanan' => 'required',
            'harga' => 'required|numeric'
        ]);

        $data = [
            'nama_layanan' => $request->nama_layanan,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'durasi' => $request->durasi
        ];

        // upload gambar
        if ($request->hasFile('gambar')) {

            $file = $request->file('gambar');

            $filename = time().'.'.$file->getClientOriginalExtension();

            $file->move(public_path('images/services'), $filename);

            $data['gambar'] = $filename;
        }

        Service::create($data);

        return redirect()->route('services.index')
            ->with('message','Layanan berhasil ditambahkan');
    }


    // =========================
    // EDIT PAGE
    // =========================
    public function edit($id)
    {

        $service = Service::findOrFail($id);

        return view('admin.service.editlayanan', [
            'service' => $service
        ]);
    }


    // =========================
    // UPDATE LAYANAN
    // =========================
    public function update(Request $request, $id)
    {

        $request->validate([
            'nama_layanan' => 'required',
            'harga' => 'required|numeric'
        ]);

        $service = Service::findOrFail($id);

        $data = [
            'nama_layanan' => $request->nama_layanan,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'durasi' => $request->durasi
        ];

        // upload gambar baru
        if ($request->hasFile('gambar')) {

            if ($service->gambar && file_exists(public_path('images/services/'.$service->gambar))) {
                unlink(public_path('images/services/'.$service->gambar));
            }

            $file = $request->file('gambar');

            $filename = time().'.'.$file->getClientOriginalExtension();

            $file->move(public_path('images/services'), $filename);

            $data['gambar'] = $filename;
        }

        $service->update($data);

        return redirect()->route('services.index')
            ->with('message','Layanan berhasil diperbarui');
    }


    // =========================
    // HAPUS LAYANAN
    // =========================
    public function destroy($id)
    {

        $service = Service::findOrFail($id);

        if ($service->gambar && file_exists(public_path('images/services/'.$service->gambar))) {

            unlink(public_path('images/services/'.$service->gambar));
        }

        $service->delete();

        return redirect()->route('services.index')
            ->with('message','Layanan berhasil dihapus');
    }

}