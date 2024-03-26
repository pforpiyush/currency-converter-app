<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Bus;

use App\Http\Controllers\CurrencyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Get progress of batch and show it to the user
Route::get('/batch/{batchId}', function (string $batchId) {
    return json_encode(Bus::findBatch($batchId)->progress());
})->name('batch');