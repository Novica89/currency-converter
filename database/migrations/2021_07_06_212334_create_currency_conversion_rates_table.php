<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyConversionRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_conversion_rates', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->string('input_currency');
            $table->string('output_currency');
            $table->decimal('conversion_rate', 11, 2);

            $table->primary(['input_currency', 'output_currency'], 'input_output_pk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency_conversion_rates');
    }
}
