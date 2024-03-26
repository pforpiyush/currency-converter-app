<?php

namespace App\Models;

use App\Http\Resources\CurrencyCodeResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Model class for currency_codes table
 */
class CurrencyCode extends Model
{
    use HasFactory;

    protected $table = 'currency_codes';

    /**
     * Get list of all currency codes
     */
    public static function getCurrencyCodes(): string
    {
        /**
         * The value has been cached forever with an assumption that the currency codes will never change.
         * An observer can be created to clear the cache if ever any currency code changes or new code is added.
         */
        return Cache::rememberForever('currency_codes', function() {
            return json_encode(CurrencyCodeResource::collection(self::all()));
        });
    }
}
