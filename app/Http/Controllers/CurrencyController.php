<?php

namespace App\Http\Controllers;
use App\Models\CurrencyCode;

use Illuminate\Http\Request;

/**
 * Controller to manage all routes related to currency conversion
 */
class CurrencyController extends Controller
{
    public function index()
    {
        return view('index', ['currencyCodes' => CurrencyCode::getCurrencyCodes()]);
    }
}
