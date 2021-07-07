<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversionRate extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'currency_conversion_rates';

    /**
     * @var string[]
     */
    protected $fillable = ['input_currency', 'output_currency', 'conversion_rate'];

    /**
     * @var bool
     */
    public $timestamps = false;

}
