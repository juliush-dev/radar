<?php

namespace App\Providers;

use App\Services\EnumTransformer;
use App\Services\QueryResultTransformer;
use App\Services\RadarQuery;
use Illuminate\Support\ServiceProvider;
use ProtoneMedia\Splade\Components\Form\Select;

class AppServiceProvider extends ServiceProvider
{


    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        RadarQuery::class => RadarQuery::class,
        EnumTransformer::class => EnumTransformer::class,
        QueryResultTransformer::class => QueryResultTransformer::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        Select::defaultChoices();
        Select::defaultChoices();
        // Splade::defaultModalCloseExplicitly();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
