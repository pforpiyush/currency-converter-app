<?php

namespace Tests\Unit;

use App\Models\CurrencyCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CurrencyCodeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test getCurrencyCodes function of CurrencyCode model
     */
    public function test_it_retrieves_list_of_all_currency_codes(): void
    {
        $this->refreshDatabase();

        $currencyCodes = CurrencyCode::factory()->count(10)->make();

        $currencyCodes = json_decode(CurrencyCode::getCurrencyCodes());

        $this->assertCount(10, $currencyCodes);
    }
}
