<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ForgetPasswordController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServiceController;

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\MemberController;

use App\Http\Controllers\DendaController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\GrafikController;



/*
|--------------------------------------------------------------------------
| PUBLIC AREA
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/detail/{id}', [HomeController::class,'detail'])->name('home.detail');

Route::post('/login',[AuthController::class,'authenticate']);


Route::get('/daftar',[RegisterController::class,'index'])->name('daftar');
Route::post('/daftar',[RegisterController::class,'store'])->name('register.store');


/*
|--------------------------------------------------------------------------
| PASSWORD RESET
|--------------------------------------------------------------------------
*/

Route::get('/forget-password',[ForgetPasswordController::class,'index'])->name('forgetpassword.index');
Route::post('/forget-password',[ForgetPasswordController::class,'sendResetLink'])->name('forgetpassword.sendlink');

Route::get('/reset/{token}',[ForgetPasswordController::class,'resetPasswordIndex']);
Route::post('/reset',[ForgetPasswordController::class,'resetPassword'])->name('resetpassword');


/*
|--------------------------------------------------------------------------
| SUPERUSER AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','superuser'])->group(function () {

    Route::prefix('admin')->group(function () {

        Route::get('/admin-management',[AdminController::class,'adminmanagement'])->name('superuser.admin');

    });

});


/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','admin'])->group(function () {

    Route::prefix('admin')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/',[AdminController::class,'index'])->name('admin.index');


        /*
        |--------------------------------------------------------------------------
        | ALAT
        |--------------------------------------------------------------------------
        */

        Route::get('/alat/{id?}',[AlatController::class,'index'])->name('alat.index');
        Route::post('/alat',[AlatController::class,'store'])->name('alat.store');

        Route::get('/alat/{id}/detail',[AlatController::class,'edit'])->name('alat.edit');
        Route::patch('/alat/{id}/detail',[AlatController::class,'update'])->name('alat.update');
        Route::delete('/alat/{id}/detail',[AlatController::class,'destroy'])->name('alat.destroy');


        /*
        |--------------------------------------------------------------------------
        | KATEGORI
        |--------------------------------------------------------------------------
        */

        Route::get('/kategori',[CategoryController::class,'index'])->name('kategori.index');
        Route::post('/kategori',[CategoryController::class,'store'])->name('kategori.store');

        Route::get('/kategori/{id}/edit',[CategoryController::class,'edit'])->name('kategori.edit');
        Route::patch('/kategori/{id}',[CategoryController::class,'update'])->name('kategori.update');
        Route::delete('/kategori/{id}',[CategoryController::class,'destroy'])->name('kategori.destroy');


        /*
        |--------------------------------------------------------------------------
        | LAYANAN
        |--------------------------------------------------------------------------
        */

        Route::get('/services',[ServiceController::class,'index'])->name('services.index');
        Route::post('/services',[ServiceController::class,'store'])->name('services.store');

        Route::get('/services/{id}/edit',[ServiceController::class,'edit'])->name('services.edit');
        Route::patch('/services/{id}',[ServiceController::class,'update'])->name('services.update');
        Route::delete('/services/{id}',[ServiceController::class,'destroy'])->name('services.destroy');


        /*
        |--------------------------------------------------------------------------
        | RESERVASI
        |--------------------------------------------------------------------------
        */

        Route::get('/penyewaan',[RentController::class,'index'])->name('penyewaan.index');
        Route::get('/penyewaan/detail/{id}',[RentController::class,'detail'])->name('penyewaan.detail');

        Route::get('/riwayat-reservasi',[RentController::class,'riwayat'])->name('riwayat-reservasi');

        Route::delete('/cancel/{id}',[RentController::class,'destroy'])->name('admin.penyewaan.cancel');


        /*
        |--------------------------------------------------------------------------
        | ORDER MANAGEMENT
        |--------------------------------------------------------------------------
        */

        Route::patch('/acc/{paymentId}',[OrderController::class,'acc'])->name('acc');

        Route::patch('/accbayar/{id}',[OrderController::class,'accbayar'])->name('accbayar');

        Route::patch('/selesai/{id}',[OrderController::class,'alatkembali'])->name('selesai');

        Route::get('/laporan/cetak',[LaporanController::class,'cetak'])->name('cetak');
        Route::patch('/admin/reject/{paymentId}', [OrderController::class, 'reject'])->name('reject');


        /*
        |--------------------------------------------------------------------------
        | BUAT RESERVASI MANUAL
        |--------------------------------------------------------------------------
        */

        Route::get('/buat-reservasi/{userId}',[AdminController::class,'newOrderIndex'])->name('admin.buatreservasi');

        Route::post('/buat-reservasi/order/{userId}',[AdminController::class,'createNewOrder'])->name('admin.createorder');
        Route::post('/cart/service/{id}/{userId}', [CartController::class, 'storeService'])->name('cart.store.service');

        /*
        |--------------------------------------------------------------------------
        | USER MANAGEMENT
        |--------------------------------------------------------------------------
        */
        Route::get('/admin/admin-management', [AdminController::class, 'adminmanagement'])
         ->name('admin.adminmanagement');
        Route::get('/usermanagement',[AdminController::class,'usermanagement'])->name('admin.user');

        Route::post('/usermanagement/new',[AdminController::class,'newUser'])->name('user.new');

        Route::patch('/user/promote/{id}',[UserController::class,'promote'])->name('user.promote');
        Route::patch('/user/demote/{id}',[UserController::class,'demote'])->name('user.demote');
        Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
        Route::put('/user/update/{id}', [UserController::class, 'updateUser'])->name('user.update');
/*
        |--------------------------------------------------------------------------
        | GRAFIK
        |--------------------------------------------------------------------------
        */
       Route::get('/admin/grafik',[GrafikController::class,'grafik'])->name('admin.grafik');
    });

});


/*
|--------------------------------------------------------------------------
| MEMBER AREA
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function() {

    Route::get('/memberarea',[MemberController::class,'index'])->name('member.index');

    Route::get('/memberarea/kalender', function() {
        return view('member.kalender');
    })->name('member.kalender');


    /*
    |--------------------------------------------------------------------------
    | CART
    |--------------------------------------------------------------------------
    */

    Route::post('/memberarea/store/{id}/{userId}',[CartController::class,'store'])->name('cart.store');

    // TAMBAHAN UNTUK LAYANAN
    Route::post('/memberarea/service/{id}/{userId}',[CartController::class,'storeService'])->name('cart.service.store');

    Route::delete('/memberarea/delete/{id}',[CartController::class,'destroy'])->name('cart.destroy');


    /*
    |--------------------------------------------------------------------------
    | ORDER
    |--------------------------------------------------------------------------
    */

    Route::post('/checkout',[OrderController::class,'create'])->name('order.create');

    Route::get('/reservasi',[OrderController::class,'show'])->name('order.show');

    Route::get('/reservasi/detail/{id}',[OrderController::class,'detail'])->name('order.detail');

    Route::patch('/bayar/{id}', [PaymentController::class,'bayar'])->name('bayar');

    Route::delete('/reservasi/cancel/{id}',[OrderController::class,'destroy'])->name('cancel');


    /*
    |--------------------------------------------------------------------------
    | SERVICE MEMBER
    |--------------------------------------------------------------------------
    */

    Route::get('/services',[ServiceController::class,'memberIndex'])->name('services.member');


    /*
    |--------------------------------------------------------------------------
    | AKUN
    |--------------------------------------------------------------------------
    */

    Route::get('/akun/pengaturan',[UserController::class,'edit'])->name('akun.pengaturan');

    Route::patch('/akun/pengaturan',[UserController::class,'update'])->name('akun.update');

    Route::patch('/changepass',[UserController::class,'changePassword'])->name('changepassword');
//
    Route::post('/denda/{paymentId}', [DendaController::class, 'store'])->name('denda.store');
    // bayar denda
    Route::patch('/denda/bayar/{id}', [DendaController::class, 'bayarDenda'])->name('denda.bayar');
    // Acc Denda
    Route::patch('/denda/acc/{id}', [DendaController::class, 'accDenda'])->name('denda.acc');
});


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::get('/logout',[AuthController::class,'logout'])->name('logout');