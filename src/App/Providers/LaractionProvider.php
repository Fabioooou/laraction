<?php

namespace Laraction\App\Providers;

use Illuminate\Support\ServiceProvider;
//use Illuminate\Pagination\Paginator;

class LaractionProvider extends ServiceProvider
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
        //Paginator::useBootstrap();

       
        $this->loadViewsFrom(dirname(__DIR__,2).'/views', 'laraction'); 
    }
}
