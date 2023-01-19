<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use App\Service\GoogleSearchService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\ResponseInterface;

#[AsController]
class GetStocks extends AbstractController
{
    private $logger;
    private $googleSearchService;

    public function __construct(LoggerInterface $logger, GoogleSearchService $googleSearchService)
    {
        $this->logger = $logger;
        $this->googleSearchService = $googleSearchService;
    }

    public function __invoke(Request $request): ResponseInterface
    {

        return $this->googleSearchService->executeSearchService(1, 1); // Should Return a Response Object + Change name function
    }
}
