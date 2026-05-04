<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Carts;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index() {

        $alat = Alat::with(['category'])->get();
        $services = Service::all();

        $carts = Carts::where('user_id','=',Auth::id());

        if(request('search')) {
            $key = request('search');
            $alat = Alat::with(['category'])
                ->where('nama_alat','LIKE','%'.$key.'%')
                ->get();
        }

        if(request('kategori')) {
            $alat = Alat::with(['category'])
                ->where('kategori_id','=',request('kategori'))
                ->get();
        }

        return view('customer.customer',[
            'alat' => $alat,
            'services' => $services,
            'carts' => $carts->get(),
            'total' => $carts->sum('harga'),
            'kategori' => Category::all()
        ]);
    }
}