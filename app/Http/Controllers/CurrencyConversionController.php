<?php

namespace App\Http\Controllers;

use App\Models\ConversionRate;
use App\Services\Formatter;
use Illuminate\Http\Request;

class CurrencyConversionController extends Controller
{

    /**
     * @var Formatter
     */
    private $formatter;

    /**
     * CurrencyConversionController constructor.
     * @param Formatter $formatter
     */
    public function __construct(Formatter $formatter)
    {

        $this->formatter = $formatter;
    }

    /**
     *
     */
    public function getConversionRates()
    {
        $rates = ConversionRate::all();
        $currencies = ConversionRate::select('input_currency')->groupBy('input_currency')->pluck('input_currency');

        return response()->json([
            'rates'         => $this->formatter->formatConversionRates($rates),
            'currencies'    => $currencies->toArray()
        ], 200);
    }

}
