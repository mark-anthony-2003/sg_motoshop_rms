<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('includes.header', function($view) {
            $cartCount = 0;
            if (Auth::check() && Auth::user()->user_type === 'customer') {
                $cartCount = Cart::where('user_id', Auth::id())->count();
            }
            $view->with('cartCount', $cartCount);
        });

        View::composer('includes.header', function($view) {
            $carts = [];
            if (Auth::check() && Auth::user()->user_type === 'customer') {
                $carts = Cart::where('user_id', Auth::id())->with('item')->get();
            }
            $view->with('carts', $carts)->with('cartCount', count($carts));
        });
    }
}
