<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use ProtoneMedia\Splade\Components\Form\Select;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Select::defaultChoices();
        Select::defaultChoices([
            'searchEnabled' => false
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
