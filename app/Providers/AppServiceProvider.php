<?php

namespace App\Providers;

use App\Models\Coach;
use App\Models\Country;
use App\Models\District;
use App\Models\Organization;
use App\Models\Region;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
        $coaches = Coach::with('user')->get();
        $orgs = Organization::all();
        $countries = Country::all();
        $districts = District::all();
        $regions = Region::all();

        View::share('coaches', $coaches);
        View::share('orgs', $orgs);
        View::share('countries', $countries);
        View::share('districts', $districts);
        View::share('regions', $regions);
    }
}
