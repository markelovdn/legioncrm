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
use Illuminate\Support\Facades\Blade;
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
        Blade::directive('hasrole', function ($arguments) {
            $roles = explode('|', $arguments);

            return "<?php if (auth()->check() && in_array(auth()->user()->role, {$roles})): ?>";
        });

        Blade::directive('endhasrole', function () {
            return '<?php endif; ?>';
        });
    }
}
