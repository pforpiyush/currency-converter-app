<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model class for history_rates table
 */
class HistoryRate extends Model
{
    /**
     * This sets the limit on number of records that can be fetched through external API
     * 
     * NOTE: The rate has been changed because only upto 10 requests can be made to the external API per minute.
     * 
     * For ideal situation, the rates would be as follows:
     * - LIMIT_DAILY = 30;
     * - LIMIT_WEEKLY = 26;
     * - LIMIT_MONTHLY = 12;
     */
    public const LIMIT_DAILY = 10;      // For one month period and daily interval

    public const LIMIT_WEEKLY = 8;      // For six month period and weekly interval

    public const LIMIT_MONTHLY = 6;     // For one year period and monthly interval

    use HasFactory;

    protected $table = 'history_rates';

}
