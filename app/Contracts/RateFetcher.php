<?php

namespace App\Contracts;

use DateTime;

interface RateFetcher
{
    public function fetchRateOnDate(DateTime $date, string $from, string $to): string;
}
