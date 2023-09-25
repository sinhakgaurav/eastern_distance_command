<?php

namespace App\Providers;

use App\Services\GeocodingService;
use App\Services\GeocodingServiceInterface;
use Illuminate\Support\ServiceProvider;
use App\Services\DistanceCalculatorInterface;
use App\Services\DistanceCalculator;
use App\Services\CSVWriterInterface;
use App\Services\CSVWriter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(GeocodingServiceInterface::class, GeocodingService::class);
        $this->app->bind(DistanceCalculatorInterface::class, DistanceCalculator::class);
        $this->app->bind(CSVWriterInterface::class, CSVWriter::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
