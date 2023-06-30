<?php

namespace App\Http\Controllers\Investment;

use App\Http\Controllers\Controller;
use App\Services\CryptoApiService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class InvestmentController extends Controller
{
    private CryptoApiService $apiService;

    public function __construct(CryptoApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index(Request $request)
    {
        $perPage = 20;

        $currentPage = $request->query('page', 1);
        $start = ($currentPage - 1) * $perPage + 1;
        $limit = $perPage;

        $cryptoData = $this->apiService->getCryptoList($start, $limit);

        $cryptocurrencies = new LengthAwarePaginator(
            $cryptoData['data'],
            $cryptoData['total'],
            $perPage,
            $currentPage,
            [
                'path' => route('investments'),
            ]
        );

        return view('investment.index', ['cryptocurrencies' => $cryptocurrencies]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $cryptocurrencies = $this->apiService->searchCrypto($search);

        return view('investment.index', ['cryptocurrencies' => $cryptocurrencies]);
    }
}
