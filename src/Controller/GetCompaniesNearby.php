<?php

namespace App\Controller;

use App\Entity\Stocks;
use Psr\Log\LoggerInterface;
use App\Service\GoogleSearchService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\ResponseInterface;

#[AsController]
class GetCompaniesNearby extends AbstractController
{
    private $logger;
    private $googleSearchService;

    public function __construct(LoggerInterface $logger, GoogleSearchService $googleSearchService)
    {
        $this->logger = $logger;
        $this->googleSearchService = $googleSearchService;
    }

    public function __invoke(): ResponseInterface
    {
        $this->logger->warning('Passed to logger');

        // Google Search Parameters attended in the request must be passed in the service

        return $this->googleSearchService->executeSearchService(); // Should Return a Response Object + Change name function
    }
}
