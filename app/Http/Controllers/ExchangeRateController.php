<?php

namespace App\Http\Controllers;



use App\Contracts\RateFetcher;
use App\Http\Requests\GetRateOnDateRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class ExchangeRateController
{
    public function getRateOnDate(GetRateOnDateRequest $request, RateFetcher $service): JsonResponse
    {
        $from = $request->validated('from');
        $to = $request->validated('to');
        $date = Carbon::parse($request->validated('date'));

        $rate = $service->fetchRateOnDate($date, $from, $to);
        $prev_day_rate = $service->fetchRateOnDate($date->subDay(), $from, $to);

        return response()->json([
            'pair' => "$from:$to",
            'date' => $date->format('Y-m-d'),
            'rate' => $rate,
            'diff_from_prev_day' => bcsub($rate, $prev_day_rate, 8)
        ]);
    }
}
