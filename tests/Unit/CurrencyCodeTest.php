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
        CurrencyCode::create(['name' => 'US Dollar', 'code' => 'USD']);
        CurrencyCode::create(['name' => 'Australian Dollar', 'code' => 'AUD']);
        CurrencyCode::create(['name' => 'Great Britain Pound', 'code' => 'GBP']);
        CurrencyCode::create(['name' => 'Japanese Yen', 'code' => 'JPY']);

        $currencyCodes = json_decode(CurrencyCode::getCurrencyCodes());

        $this->assertCount(4, $currencyCodes);
        
        $this->assertTrue($currencyCodes->contains('USD'));
        $this->assertTrue($currencyCodes->contains('AUD'));
        $this->assertTrue($currencyCodes->contains('Japanese Yen'));
        $this->assertTrue($currencyCodes->contains('Great Britain Pound'));
    }
}
