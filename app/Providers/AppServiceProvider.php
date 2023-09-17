<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use ProtoneMedia\Splade\Components\Form\Select;
use ProtoneMedia\Splade\Facades\Splade;

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
        // Splade::defaultModalCloseExplicitly();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
