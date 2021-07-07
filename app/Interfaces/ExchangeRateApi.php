<?php


namespace App\Interfaces;


interface ExchangeRateApi
{
    public function getConversionRates($for_currency = null);
}
