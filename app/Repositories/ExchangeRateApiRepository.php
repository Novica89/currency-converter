<?php

namespace App\Repositories;

use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Interfaces\ExchangeRateApi;

class ExchangeRateApiRepository implements ExchangeRateApi
{

    // do a call via API to external service that provides conversion rates (actually fetch rates from our DB)
    public function getConversionRates($for_currency = null)
    {
        $rates = Currency::rates()->latest();

        if(! is_null($for_currency)) {
            $rates = $rates->base($for_currency);
        }

        return $rates->round(2)->get();
    }
}
