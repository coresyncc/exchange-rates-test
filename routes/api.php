<?php

use App\Http\Controllers\ExchangeRateController;
use Illuminate\Support\Facades\Route;

Route::get('/rates_on_date', [ExchangeRateController::class, 'getRateOnDate']);
