<?php
namespace App\Controller;

use App\Entity\Stocks;
use App\Service\GoogleSearchService;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    public function __invoke(Request $request): array
    {
        $this->logger->warning('Passed to logger')
        $this->logger->info($request);

        $this->googleSearchService->getHappyMessage();
        $stocks = new Stocks()
        return $;
    }
}