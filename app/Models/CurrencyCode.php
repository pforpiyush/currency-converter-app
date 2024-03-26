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

    public static function getCurrencyCodes()
    {
        return Cache::rememberForever('currency_codes', function() {
            return json_encode(CurrencyCodeResource::collection(self::all()));
        });
    }
}
