<?php declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class CurrencyApiService
{
    protected Client $client;
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.freecurrencyapi.com/v1/',
            'headers' => [
                'apikey' => $_ENV['CURRENCY_API'],
            ],
        ]);
    }

    public function getCurrencies(): array
    {
        $currencies = [];
        $currencyInfo = $this->fetchCurrencyInfo();
        foreach ($currencyInfo->data as $record) {
            $currencies[] = $record->code;
        }

        return $currencies;
    }

    public function getConversionRate($from, $to): float
    {
        $cacheKey = "{$from}_to_{$to}";

        if (Cache::has($cacheKey)) {
            $conversionRate = Cache::get($cacheKey);
        } else {
            $response = $this->client->get("latest?base_currency={$from}&currencies={$to}");
            $result = json_decode($response->getBody()->getContents());

            $conversionRate = $result->data->{$to};
            Cache::put($cacheKey, $conversionRate, 60);
        }

        return $conversionRate;
    }

    public function fetchCurrencyInfo()
    {
        if (Cache::has('currency_data')) {
            $record = Cache::get('currency_data');
        } else {
            $response = $this->client->get('currencies');
            $record = json_decode($response->getBody()->getContents());

            Cache::put('currency_data', $record, 60);
        }
        return $record;
    }
}
