<?php declare(strict_types=1);

namespace App\Services;

use App\Models\Cryptocurrency;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class CryptoApiService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://pro-api.coinmarketcap.com/v1/',
            'headers' => [
                'X-CMC_PRO_API_KEY' => $_ENV['CRYPTO_API'],
            ],
        ]);
    }

    public function getCryptoList($start, $limit): array
    {
        $cryptoList = [];
        $record = $this->fetchCryptoInfoPaginated($start, $limit);
        foreach ($record->data as $crypto) {
            $cryptoList[] = $this->buildModel($crypto);
        }
        return [
            'data' => collect($cryptoList),
            'total' => $record->status->total_count,
        ];
    }

    public function searchCrypto(string $query): array
    {
        $record = $this->fetchAll();
        $cryptoList = [];
        $query = strtolower($query);

        foreach ($record->data as $crypto) {
            if (str_contains(strtolower($crypto->name), $query) || str_contains(strtolower($crypto->symbol), $query)) {
                $cryptoList[] = $this->buildModel($crypto);
            }
        }
        return $cryptoList;
    }

    public function fetchById($id): Cryptocurrency
    {
        $cacheKey = 'crypto_data' . $id;
        if (Cache::has($cacheKey)) {
            $record = Cache::get($cacheKey);
        } else {
            $response = $this->client->get("cryptocurrency/quotes/latest?id=$id");
            $record = json_decode($response->getBody()->getContents());
        }
        return $this->buildModel($record->data->$id);
    }

    private function fetchCryptoInfoPaginated($start, $limit)
    {
        $cacheKey = 'crypto_data' . $start . '-' . $limit;
        if (Cache::has($cacheKey)) {
            $record = Cache::get($cacheKey);
        } else {
            $response = $this->client->get("cryptocurrency/listings/latest?start=$start&limit=$limit");
            $record = json_decode($response->getBody()->getContents());

            Cache::put($cacheKey, $record, 60);
        }
        return $record;
    }

    private function fetchAll()
    {
        $cacheKey = 'crypto_data';
        if (Cache::has($cacheKey)) {
            $record = Cache::get($cacheKey);
        } else {
            $response = $this->client->get("cryptocurrency/listings/latest");
            $record = json_decode($response->getBody()->getContents());

            Cache::put($cacheKey, $record, 600);
        }
        return $record;
    }

    private function buildModel(\stdClass $record): Cryptocurrency
    {
        return new Cryptocurrency(
            $record->id,
            $record->name,
            $record->symbol,
            $record->quote->USD->percent_change_1h,
            $record->quote->USD->percent_change_24h,
            $record->quote->USD->percent_change_7d,
            $record->quote->USD->price
        );
    }
}
