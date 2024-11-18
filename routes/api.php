<?php

use App\Http\Controllers\ExchangeRateController;
use Illuminate\Support\Facades\Route;

Route::get('/rates', [ExchangeRateController::class, 'getRateOnDate']);
