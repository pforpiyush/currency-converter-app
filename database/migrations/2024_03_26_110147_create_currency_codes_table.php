<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create the table
        Schema::create('currency_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->timestamps();
        });

        // Fetch e from the external API
        $response = Http::get(env('CURRENCY_LAYER_CURRENCY_CODES_URL'), [
            'apikey' => env('CURRENCY_LAYER_API_KEY'),
        ]);

        if ($response->successful()) {
            $currencies = $response->json();
        } else {
            // Fall back to list of some popular currencies
            $currencies = [
                'data' => [
                    ['code' => 'USD', 'name' => 'US Dollar'],
                    ['code' => 'AUD', 'name' => 'Australian Dollar'],
                    ['code' => 'JPY', 'name' => 'Japanese Yen'],
                    ['code' => 'GBP', 'name' => 'Great Brittan Pound'],
                    ['code' => 'EUR', 'name' => 'European Euro'],
                    ['code' => 'INR', 'name' => 'Indian Ruppee'],
                    ['code' => 'ISK', 'name' => 'Icelandic Krona'],
                    ['code' => 'SGD', 'name' => 'Singaporean Dollar'],
                ],
            ];
        }

        foreach ($currencies['data'] as $currency) {
            // Insert each post into the database
            DB::table('currency_codes')->insert([
                'code' => $currency['code'],
                'name' => $currency['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the table if the migration is rolled back
        Schema::dropIfExists('currency_codes');
    }
};
