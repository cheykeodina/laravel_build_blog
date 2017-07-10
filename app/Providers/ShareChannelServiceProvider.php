<?php

namespace App\Providers;

use App\Channel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ShareChannelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Method 1 user composer method
        View::composer('*', function ($view) {
            $channels = Cache::rememberForever('channels', function(){
               return Channel::all();
            });
            $view->with('channels', $channels);
        });

        // Method 2 use shareWith Method
//        View::share('channels', Channel::all());
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
