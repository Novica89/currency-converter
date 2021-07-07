<?php

namespace App\Console\Commands;

use App\Interfaces\ExchangeRateApi;
use App\Models\ConversionRate;
use Illuminate\Console\Command;

class RefreshCurrencyPairRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:refresh-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run a command that will refresh all of the existing currency pairs and updated their conversion rates.';

    /**
     * Execute the console command.
     *
     * @param ExchangeRateApi $exchangeRateApi
     * @return int
     */
    public function handle(ExchangeRateApi $exchangeRateApi)
    {
        $current_ticker = 'USD';
        $rates = $exchangeRateApi->getConversionRates($current_ticker);

        if(is_null($rates) || !is_array($rates)) {
            return 0;
        }

        $data = [];

        foreach ($rates as $ticker => $conversion_rate) {
            $tickerRates = $exchangeRateApi->getConversionRates($ticker);

            foreach ($tickerRates as $output_currency => $ticker_conversion_rate) {
                if(is_null($ticker_conversion_rate)) continue;
                $data[] = ['id' => count($data) + 1, 'input_currency'=> $ticker, 'output_currency' => $output_currency, 'conversion_rate' => $ticker_conversion_rate];
            }

            sleep(1);
        }

        if(count($data)) {
            $dataCollection = collect($data);
            $dataCollectionChunks = $dataCollection->chunk(1000)->all();
            foreach ($dataCollectionChunks as $dataCollectionChunk) {
                // this call will update or insert new rows depending on whether they already exist in the table or not.
                // if they exist, it will only update conversion_rate column
                ConversionRate::upsert($dataCollectionChunk->toArray(), ['input_currency', 'output_currency'], ['conversion_rate']);
            }
        }

        $this->info('conversion rates updated');
        return 0;
    }
}
