<?php
namespace App\Controller;

use App\Entity\Stocks;
use App\Service\GoogleSearchService;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

#[AsController]
class GetStockNearbyPublication extends AbstractController
{
    private $logger;
    private $googleSearchService;

    public function __construct(LoggerInterface $logger, GoogleSearchService $googleSearchService)
    {
        $this->logger = $logger;
        $this->googleSearchService = $googleSearchService;
    }

    public function __invoke(Request $request): Response
    {
        $this->logger->warning('Passed to logger')
        $this->logger->info($request);
        
        // Google Search Parameters attended in the request must be passed in the service

        return $this->googleSearchService->getHappyMessage(); // Should Return a Response Object + Change name function
    }
}
