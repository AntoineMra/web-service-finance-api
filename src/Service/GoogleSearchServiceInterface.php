<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface GoogleSearchServiceInterface
{
    public function executeSearchService(float $long, float $lat): ResponseInterface;
}
