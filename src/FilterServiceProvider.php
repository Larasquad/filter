<?php

namespace Larasquad\Filter;

use Illuminate\Support\ServiceProvider;
use Larasquad\Filter\Console\MakeFilter;

class FilterServiceProvider extends ServiceProvider
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
       $this->commands([
           MakeFilter::class,
       ]);
    }
}
