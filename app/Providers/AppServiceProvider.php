<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Carbon\Carbon;

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
        Relation::morphMap([
            'news' => 'App\Models\News',
            'destination' => 'App\Models\Destination',
            'package' => 'App\Models\Package',
        ]);

        config(['app.locale' => 'id']);
	    Carbon::setLocale('id');
    }
}
