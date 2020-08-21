<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use Illuminate\Contracts\View\View;
use App\Settings;

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
        date_default_timezone_set('Africa/Lagos');
        /*view()->composer('*', function(View $view) {
            $confs = Settings::where(['type_id'=>'4','user_id'=>'1'])->first();
            $view->with('confs', $confs);
        });*/
    }
}
