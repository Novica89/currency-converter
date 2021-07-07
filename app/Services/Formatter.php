<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

class Formatter
{

    public function formatConversionRates(Collection $collection) {
        // first run to group the top level currencies (base currencies)
        $first_run = $collection->groupBy(['input_currency']);

        // for each of the base currencies we run groupBy again to extract their underlying output currencies as well
        // so that we have a nice array structure
        /*
         * In the end array structure will be:
         *
         * "USD" => ["AED" => ["conversion_rate" => 0.10], "EUR" => ["conversion_rate" => 0.80]] etc
         *
         *
         * */
        foreach ($first_run as $key => $first_run_item) {
            $first_run[$key] = $first_run_item->groupBy(['output_currency']);
        }

        // in the end we make sure that everything is an array
        return $first_run->toArray();
    }

}
