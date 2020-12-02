<?php

namespace App\Providers;

use App\Services\GetOrderInformationFromAPI;
use App\Services\GetOrderInformationFromBD;
use App\Services\GetOrderInformationInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(GetOrderInformationInterface::class, function () {
            $strategy = config('order.information_strategy', 'bd');
            if ('bd' === $strategy) {
                return new GetOrderInformationFromBD();
            } else {
                return new GetOrderInformationFromAPI();
            }
        });
    }
}
