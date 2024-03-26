<?php

namespace App\Jobs;

use App\Models\HistoryRate;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ConversionRateHistoryJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public $currencyCode;

    public $dates;

    public $period;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(string $currencyCode, string $date)
    {
        $this->currencyCode = $currencyCode;
        $this->dates = $date;
    }

    public function uniqueId(): string
    {
        return $this->currencyCode;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = Http::get(env('CURRENCY_LAYER_HISTORY_RATES_URL'), [
            'apikey' => env('CURRENCY_LAYER_API_KEY'),
            'currencies' => $this->currencyCode,
            'date' => $this->dates,
        ]);
        $data = $response->json()['data'];

        $historicalRate = new HistoryRate();
        $historicalRate->exchange_date = $this->dates;
        $historicalRate->currency_code = $this->currencyCode;
        $historicalRate->value = $data[$this->dates][$this->currencyCode];
        $historicalRate->save();
    }
}
