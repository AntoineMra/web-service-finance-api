<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface StocksSearchServiceInterface
{
    public function companySearchService(string $body): ResponseInterface;

    public function stocksSearchService(string $body): ResponseInterface;
}
