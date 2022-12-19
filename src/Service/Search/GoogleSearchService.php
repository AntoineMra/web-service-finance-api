<?php

namespace App\Service;

class GoogleSearchService
{
    public function executeSearchService(string $body): string
    {
        $options = [
            'body' => $body,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                // Add API KEY + Query Params ?
            ],
        ];
        // Add %env(url)
        $response = $this->brmsClient->request('POST', self::PATH_EXECUTE_DECISION_SERVICE, $options);

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            // Throw Log Error in Logger
        }

        if (!str_contains($response->getHeaders()['content-type'][0], 'application/json')) {
             // Throw Log Error in Logger
        }

        $content = $response->getContent();
        if ($content === '') {
             // Throw Log Error in Logger
        }

        return $content;
    }
}
