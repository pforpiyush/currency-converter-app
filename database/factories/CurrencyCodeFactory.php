<?php

namespace Database\Factories;

use App\Models\CurrencyCode;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CurrencyCode>
 */
class CurrencyCodeFactory extends Factory
{
    protected $model = CurrencyCode::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'code' => Str::random(3),
        ];
    }
}
