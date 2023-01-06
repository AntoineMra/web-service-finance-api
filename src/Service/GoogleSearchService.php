<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use App\Service\GoogleSearchServiceInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GoogleSearchService implements GoogleSearchServiceInterface
{
    private $baseUrl;
    private $apiKey;

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly LoggerInterface $logger,
        string $baseUrl,
        string $apiKey
    ) {
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
    }

    public function executeSearchService(): ResponseInterface
    {
        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'query' => [
                'keyword' => "cruise",
                'location' => "-33.8670522,151.1957362",
                'radius' => "1500",
                'type' => "restaurant",
                'key' => $this->apiKey
            ],
        ];
        $response = $this->client->request('GET', $this->baseUrl . 'nearbysearch/json', $options);

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            $this->logger->error($response->getStatusCode());
        }

        if (!str_contains($response->getHeaders()['content-type'][0], 'application/json')) {
            $this->logger->error('Wrong content type');
        }

        $content = $response->getContent();
        if ($content === '') {
            $this->logger->error('Content is empty');
        }

        return $response;
    }
}
