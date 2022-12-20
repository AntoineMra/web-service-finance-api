<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoogleSearchService
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly LoggerInterface $logger
    ) {
    }
    
    public function executeSearchService(string $body): string
    {
        $options = [
            'body' => $body, // Check if body is necessary in google documentatin
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                // Add API KEY + Query Params ?
            ],
        ];
        // Add %env(url) get env ? sinon parametrer un argument dans serivce.yml
        $response = $this->client->request('POST', self::PATH_EXECUTE_DECISION_SERVICE, $options);

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
