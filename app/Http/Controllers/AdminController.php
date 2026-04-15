<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Service;
use App\Models\Carts;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index() {
        $topUser = User::withCount('payment')->orderBy('payment_count', 'DESC')->limit(5)->get();
        $topProducts = Alat::withCount('order')->orderBy('order_count', "DESC")->limit(5)->get();
        return view('admin.admin',[
            'loggedUsername' => Auth::user()->name,
            'total_user' => User::where('role',0)->count(),
            'total_alat' => Alat::count(),
            'total_kategori' => Category::count(),
            'total_penyewaan' => Payment::count(),
            'top_user' => $topUser,
            'top_products' => $topProducts
        ]);
    }

    public function usermanagement() {
         if (Auth::user()->role != 2) {
        abort(403);
    }
        $user = User::with(['payment'])->get();

        return view('admin.user.user',[
            'penyewa' => $user->where('role', 0)
        ]);
    }

    public function adminmanagement() {
    if (Auth::user()->role != 2) {
        abort(403);
    }
       $admin = User::where('role', '>', 0)
            ->orderBy('role', 'desc') 
            ->get();

    return view('admin.user.admin_management',[
    'admin' => $admin,
]);
        
    }

    public function newUser(Request $request) {
           if (Auth::user()->role != 2) {
        abort(403);
         }
        $validated = $request->validate([
    'name' => 'required|max:255',
    'email' => [
    'required',
    'email',
    'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
    'unique:users,email'
    ],
    'password' => 'required|min:5|max:255',
    'telepon' => 'required|max:15',
    'role' => 'required|in:0,1,2'
]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = $request->role ?? 0;

   User::create($validated);

    if ($validated['role'] == 0) {
    return redirect(route('admin.user'));
    }   else {
    return redirect(route('admin.adminmanagement'));
    }
    }

    public function newOrderIndex($userId) {
        $user = User::find($userId);
        $alat = Alat::with(['category'])->get();
        $service = Service::all();
        $cart = Carts::with(['user'])->where('user_id', $userId)->get();

        return view('admin.penyewaan.reservasibaru',[
            'user' => $user,
            'alat' => $alat,
            'service' => $service,
            'cart' => $cart,
            'total' => $cart->sum('harga')
        ]);
    }

    public function createNewOrder(Request $request, $userId) {
        $cart = Carts::where('user_id', $userId)->get();
        $pembayaran = new Payment();

        $pembayaran->no_invoice = $userId."/".Carbon::now()->timestamp;
        $pembayaran->user_id = $userId;
        $pembayaran->status = 3;
        $pembayaran->total = $cart->sum('harga');
        $pembayaran->save();

        foreach($cart as $c) {
            Order::create([
                'alat_id' => $c->alat_id,
                'user_id' => $c->user_id,
                'payment_id' => Payment::where('user_id',$userId)->orderBy('id','desc')->first()->id,
                'durasi' => $c->durasi,
                'starts' => date('Y-m-d H:i', strtotime($request['start_date'].$request['start_time'])),
                'ends' => date('Y-m-d H:i', strtotime($request['start_date'].$request['start_time']."+".$c->durasi." hours")),
                'harga' => $c->harga,
                'status' => 2
            ]);
            $c->delete();
        }

        return redirect(route('penyewaan.index'));
    }
}
