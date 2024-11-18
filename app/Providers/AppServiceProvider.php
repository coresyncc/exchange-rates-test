<?php

namespace App\Providers;

use App\Contracts\RateFetcher;
use App\Services\CbrRatesService;
use Illuminate\Support\ServiceProvider;
use SoapClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(RateFetcher::class, CbrRatesService::class);

        $this->app->singleton(SoapClient::class, function () {
            return new SoapClient('https://www.cbr.ru/DailyInfoWebServ/DailyInfo.asmx?WSDL', [
                'exceptions' => true,
                'keep_alive' => false,
                'soap_version' => SOAP_1_2,
                'cache_wsdl' => WSDL_CACHE_NONE,
            ]);
        });
    }
}
