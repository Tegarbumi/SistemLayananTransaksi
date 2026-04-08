<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Carts;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Format currency
        Blade::directive('money', function ($amount) {
            return "<?php echo 'Rp' . number_format($amount, 0); ?>";
        });

        // 
        View::composer('*', function ($view) {

            if (Auth::check()) {
                $carts = Carts::where('user_id', Auth::id())->get();
                $total = $carts->sum('harga');

                $view->with([
                    'carts' => $carts,
                    'total' => $total
                ]);
            }

        });
    }
}