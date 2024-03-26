<?php

namespace App\Http\Controllers;

use App\Models\HistoryRate;
use App\Http\Resources\HistoryRateResource;
use App\Jobs\ConversionRateHistoryJob;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Bus;

/**
 * Controller to handle all /history-rates endpoint
 */
class HistoryRateController extends Controller
{
    public function index()
    {
        return view('history');
    }

    public function store(Request $request)
    {
        $currencyCode = $request->input('currencyCode');
        $intervalPeriod = $request->input('intervalPeriod');

        $dates = [];
        $limit = null;

        // We limit the number of queries to external API
        // And only get the ones that we would need
        if ('daily' === $intervalPeriod) {
            $date = Carbon::yesterday();
            $limit = HistoryRate::LIMIT_DAILY;

            for ($i = 0; $i < HistoryRate::LIMIT_DAILY; $i++) {
                $dates[] = $date->format('Y-m-d');
                $date = $date->subDay();
            }
        } elseif ('weekly' === $intervalPeriod) {
            $date = Carbon::yesterday();
            $limit = HistoryRate::LIMIT_WEEKLY;

            for ($i = 0; $i < HistoryRate::LIMIT_WEEKLY; $i++) {
                $dates[] = $date->format('Y-m-d');
                $date = $date->subWeek();
            }
        } elseif ('monthly' === $intervalPeriod) {
            $date = Carbon::yesterday();
            $limit = HistoryRate::LIMIT_MONTHLY;

            for ($i = 0; $i < HistoryRate::LIMIT_MONTHLY; $i++) {
                $dates[] = $date->format('Y-m-d');
                $date = $date->subMonth();
            }
        }

        /**
         * Ideally, this query can be cached and reduce the query load and time
         * But, there is a known issue in laravel where the unique queries are not getting
         * cached even when passing on unique slugs.
         * 
         * This requires extra amount of debugging and work around, but this was the approach
         * that I would have implemented as.
         * 
         * $secondsToMidnight = Carbon::now()->endOfDay()->diffInSeconds();
         * $cacheKey = sprintf('%s_exchange_rates_%s', $currencyCode, $intervalPeriod);
         * 
         * $values = HistoricalRateResource::collection(
         *   Cache::remember($cacheKey, $secondsToMidnight, function () use ($currencyCode, $dates) {
         *       return HistoricalRate::where('currency_code', $currencyCode)
         *           ->whereIn('exchange_date', $dates)
         *           ->orderByDesc('exchange_date')
         *           ->get();
         *       })
         *   );
         * 
         * The values would have been cached until midnight as the next day the interval would change
         */

        $values = HistoryRateResource::collection(
                    HistoryRate::select('currency_code', 'exchange_date', 'value')
                        ->where('currency_code', $currencyCode)
                        ->whereIn('exchange_date', $dates)
                        ->orderByDesc('exchange_date')
                        ->distinct()
                        ->get()
                );

        /**
         * We check the condition for batching based on number of values retrieved from database,
         * since there can be some overlapping of the values.
         * 
         * So if the number of values retrieved is exactly same as the interval limits,
         * then we have all the values we need and no need to batch the values from external API
         */
        if (count($values) == $limit) {
            return json_encode($values);
        }

        $batch = Bus::batch([])->dispatch();

        // Create a job for every date based on interval
        // and return batch id for progress
        foreach ($dates as $date) {
            $batch->add(new ConversionRateHistoryJob($currencyCode, $date));
        }

        return json_encode(['batch' => $batch]);
    }
}
