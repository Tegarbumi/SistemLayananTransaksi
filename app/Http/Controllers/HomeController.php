<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Category;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        $alats = Alat::with(['category']);

        if($request->search){
            $alats->where('nama_alat','LIKE','%'.$request->search.'%');
        }

        if($request->kategori){
            $alats->where('kategori_id',$request->kategori);
        }

        $alats = $alats->get();

        return view('home',[
            'alats' => $alats,
            'categories' => Category::all(),
            'services' => Service::all()
        ]);
    }


    public function detail($id)
    {
        $detail = Alat::with(['category'])->find($id);

        return view('detail',[
            'detail' => $detail,
            'order' => Order::where('alat_id', $id)
                ->where('status', 2)
                ->orderBy('starts','DESC')
                ->get()
        ]);
    }
}