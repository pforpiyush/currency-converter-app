<?php

namespace Tests\Feature\Currency;

use Illuminate\Support\Facades\Http;

use App\Models\User;
use Tests\TestCase;

class CurrencyConversionTest extends TestCase
{
    /**
     * Test the response is being retrieved from external end-point
     */
    public function test_latest_rates_are_retrieved_from_external_API(): void
    {
        Http::fake([
            'https://api.freecurrencyapi.com/v1/*' => Http::response([
                'data' => [
                    'AUD' => 1.59,
                    'GBP' => 0.79,
                    'JPY' => 151.41,
                ]
            ], 200),
        ]);
        
        // Ignoring request parameters
        $response = $this->post('/currencies');

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'AUD' => 1.59,
                'GBP' => 0.79,
                'JPY' => 151.41,
            ]
        ]);
    }
}
