<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoogleSearchService
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
    
    public function executeSearchService(string $body): string
    {
        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                // Add API KEY + Query Params ?
            ],
            'query' => [
                'token' => '...',
                'name' => '...',
            ],
        ];
        // Add %env(url) get env ? sinon parametrer un argument dans serivce.yml
        $response = $this->client->request('GET', $baseUrl.'', $options);

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

        return $content;
    }
}
