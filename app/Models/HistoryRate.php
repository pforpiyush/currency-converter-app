<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryRate extends Model
{
    public const LIMIT_DAILY = 10;

    public const LIMIT_WEEKLY = 6;

    public const LIMIT_MONTHLY = 4;

    use HasFactory;

    protected $table = 'history_rates';

}
