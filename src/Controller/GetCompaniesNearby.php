<?php

namespace App\Controller;

use App\Entity\Stocks;
use App\Entity\Location;
use App\Entity\Companies;
use Psr\Log\LoggerInterface;
use App\Service\GoogleSearchService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class GetCompaniesNearby extends AbstractController
{
    private $logger;
    private $googleSearchService;
    private $security;

    public function __construct(
        LoggerInterface $logger,
        GoogleSearchService $googleSearchService,
        Security $security
    ) {
        $this->logger = $logger;
        $this->googleSearchService = $googleSearchService;
        $this->security = $security;
    }

    public function __invoke(): ArrayCollection
    {
        $this->logger->warning('Passed to logger');

        $response = $this->googleSearchService->executeSearchService();
        $places = $response->toArray()['results'];

        $collection = new ArrayCollection();
        $this->logger->warning($response->getContent());

        foreach ($places as $place) {
            $companies = new Companies();
            $companies->addUser($this->security->getUser());
            $companies->setName($place['name']);
            $companies->setTypes($place['types']);
            //[$lat, $long] = $place['geometry']['location'];
            $lat = -33.8587323;
            $long = 151.2100055;
            $companies->setLocation(new Location($lat, $long));

            $collection->add($companies);
        }

        return $collection;
    }
}
