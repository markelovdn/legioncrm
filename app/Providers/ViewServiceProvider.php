<?php

namespace App\Providers;

use App\View\Composers\ProfileComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        $user = \App\Models\User::query()->where('id', auth()->user()->id)->first();

        // Using class based composers...
//        View::composer('profile', ProfileComposer::class);

        // Using closure based composers...
//        View::composer('dashboard', function ($view) {
//            //
//        });
    }
}
