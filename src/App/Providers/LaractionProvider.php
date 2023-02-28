<?php

namespace Laraction\App\Providers;

use Illuminate\Support\ServiceProvider;
use Laraction\Commands\LaractionInstall;


class LaractionProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $src = dirname(__DIR__,2);

        $this->commands([
            LaractionInstall::class,
        ]);

        $this->mergeConfigFrom($src.'config/laraction.php', 'laraction');
        $this->loadRoutesFrom($src. 'routes/laraction.php');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $src = dirname(__DIR__,2);


        $this->publishes([
             $src .'config/laraction.php' => config_path('laraction.php'),
         ], 'config');

        $this->publishes([
             $src .'stubs/laraction/action.stub' => base_path('stubs/laraction/action.stub'),
         ], 'stubs');

        $this->publishes([
             $src .'stubs/laraction/dto.stub' => base_path('stubs/laraction/dto.stub'),
         ], 'stubs');

        $this->publishes([
             $src .'stubs/laraction/model.stub' => base_path('stubs/laraction/model.stub'),
         ], 'stubs');

        $this->publishes([
             $src .'stubs/laraction/route-action.stub' => base_path('stubs/laraction/route-action.stub'),
         ], 'stubs');

        $this->publishes([
             $src .'stubs/laraction/route-group.stub' => base_path('stubs/laraction/route-group.stub'),
         ], 'stubs');

        $this->publishes([
             $src .'stubs/laraction/validation.stub' => base_path('stubs/laraction/validation.stub'),
         ], 'stubs');




        
        //$this->loadViewsFrom(dirname(__DIR__,2).'/views', 'laraction'); 


    }
}
