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
        $src = dirname(__DIR__,2) . DIRECTORY_SEPARATOR;

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

        $src = dirname(__DIR__,2) . DIRECTORY_SEPARATOR;


        $this->publishes([
             $src .'config/laraction.php' => config_path('laraction.php'),
         ], 'config');

        $this->publishes([
             $src .'stubs/laraction/action.stub' => base_path('stubs/laraction/action.stub'),
         ], 'stubs');

         $this->publishes([
            $src .'stubs/laraction/action_simple.stub' => base_path('stubs/laraction/action_simple.stub'),
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

        $this->publishes([
            $src .'stubs/laraction/create_form.stub' => base_path('stubs/laraction/create_form.stub'),
        ], 'stubs');

        $this->publishes([
            $src .'stubs/laraction/paginate.stub' => base_path('stubs/laraction/paginate.stub'),
        ], 'stubs');

        $this->publishes([
            $src .'stubs/laraction/layout.stub' => base_path('stubs/laraction/layout.stub'),
        ], 'stubs');


         # form stubs
        $this->publishes([
            $src .'stubs/laraction/form/input_text.stub' => base_path('stubs/laraction/form/input_text.stub'),
        ], 'stubs');

        # operation stubs
        $this->publishes([
            $src .'stubs/laraction/operation/action_create_form.stub' => base_path('stubs/laraction/operation/action_create_form.stub'),
        ], 'stubs');

        $this->publishes([
            $src .'stubs/laraction/operation/action_create.stub' => base_path('stubs/laraction/operation/action_create.stub'),
        ], 'stubs');

        $this->publishes([
            $src .'stubs/laraction/operation/action_delete.stub' => base_path('stubs/laraction/operation/action_delete.stub'),
        ], 'stubs');

        $this->publishes([
            $src .'stubs/laraction/operation/action_paginate.stub' => base_path('stubs/laraction/operation/action_paginate.stub'),
        ], 'stubs');

        $this->publishes([
            $src .'stubs/laraction/operation/action_save_form.stub' => base_path('stubs/laraction/operation/action_save_form.stub'),
        ], 'stubs');

        $this->publishes([
            $src .'stubs/laraction/operation/action_save.stub' => base_path('stubs/laraction/operation/action_save.stub'),
        ], 'stubs');

        $this->publishes([
            $src .'stubs/laraction/operation/view_create.stub' => base_path('stubs/laraction/operation/view_create.stub'),
        ], 'stubs');

        $this->publishes([
            $src .'stubs/laraction/operation/view_delete.stub' => base_path('stubs/laraction/operation/view_delete.stub'),
        ], 'stubs');

        $this->publishes([
            $src .'stubs/laraction/operation/view_save_form.stub' => base_path('stubs/laraction/operation/view_save_form.stub'),
        ], 'stubs');

        $this->publishes([
            $src .'stubs/laraction/operation/view_save.stub' => base_path('stubs/laraction/operation/view_save.stub'),
        ], 'stubs');

        # views
        $this->loadViewsFrom($src . 'views', 'laraction');

    }
}
