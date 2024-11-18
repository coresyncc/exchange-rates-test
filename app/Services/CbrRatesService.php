<?php

namespace App\Services;

use App\Contracts\RateFetcher;
use App\Exceptions\CurrencyNotFound;
use DateTime;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use SoapClient;
use SoapFault;

readonly class CbrRatesService implements RateFetcher
{
    public function __construct(
        private CacheInterface $cache,
    )
    {
    }

    /**
     * @throws SoapFault
     * @throws CurrencyNotFound
     */
    private function requestToCbr(string $date, string $from_currency, string $to_currency): string
    {
        $soap = app(SoapClient::class);

        dump(spl_object_id($soap));

        $response_xml = $soap->GetCursOnDate([
            'On_date' => $date
        ])->GetCursOnDateResult->any;

        $xml_object = simplexml_load_string($response_xml);
        $response_array = json_decode(json_encode($xml_object), true);

        foreach ($response_array['ValuteData']['ValuteCursOnDate'] as $rate_to_rub) {
            if ($from_currency === $rate_to_rub['VchCode']) {
                $from_currency_rate = $rate_to_rub['VunitRate'];
                if ($to_currency === 'RUB') {
                    return $from_currency_rate;
                }
            }
            if ($to_currency !== 'RUB' && $to_currency === $rate_to_rub['VchCode']) {
                $to_currency_rate = $rate_to_rub['VunitRate'];
            }
        }

        if (!isset($from_currency_rate) || !isset($to_currency_rate)) {
            throw new CurrencyNotFound('Currency not found', 404);
        }

        return bcdiv($from_currency_rate, $to_currency_rate, 8);
    }

    /**
     * @throws SoapFault
     * @throws InvalidArgumentException
     * @throws CurrencyNotFound
     */
    public function fetchRateOnDate(DateTime $date, string $from, string $to): string
    {
        $date_string = $date->format('Y-m-d');
        $cache_key = "$from:$to:$date_string";

        if ($cached = $this->cache->get($cache_key)) {
            return $cached;
        }

        $rate = $this->requestToCbr($date_string, $from, $to);

        $this->cache->set($cache_key, $rate);

        return $rate;
    }
}
