<?php

namespace App\Http\Controllers;
use App\Models\CurrencyCode;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

/**
 * Controller to manage all routes related to currency conversion
 */
class CurrencyController extends Controller
{
    /**
     * Route for /currencies
     */
    public function index()
    {
        return view('index', ['currencyCodes' => CurrencyCode::getCurrencyCodes()]);
    }

    /**
     * Get list of supported currencies
     * 
     * The route goes through API middleware so it needs to apply route as /api/routes
     */
    public function list(Request $request)
    {
        $selectedValues = $request->input('selectedValue');

        $response = Http::get(env('CURRENCY_LAYER_LATEST_RATES_URL'), [
            'apikey' => env('CURRENCY_LAYER_API_KEY'),
            'currencies' => $selectedValues,
        ]);
        $currencies = $response->json();

        return response()->json($currencies);
    }
}
