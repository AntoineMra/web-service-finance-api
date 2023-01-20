<?php

namespace App\Controller;

use App\Entity\Stocks;
use App\Entity\Location;
use App\Entity\Companies;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Uuid;
use App\Service\GoogleSearchService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class GetCompaniesNearby extends AbstractController
{
    private $logger;
    private $googleSearchService;
    private $security;
    private $doctrine;

    public function __construct(
        LoggerInterface $logger,
        GoogleSearchService $googleSearchService,
        Security $security,
        ManagerRegistry $doctrine
    ) {
        $this->logger = $logger;
        $this->googleSearchService = $googleSearchService;
        $this->security = $security;
        $this->doctrine = $doctrine;
    }

    public function __invoke(Request $request): ArrayCollection
    {
        $em = $this->doctrine->getManager();

        ['long' => $long, 'lat' => $lat] = $request->toArray();
        $response = $this->googleSearchService->executeSearchService($long, $lat);
        $places = $response->toArray()['results'];

        $collection = new ArrayCollection();
        $this->logger->debug($response->getContent());


        foreach ($places as $place) {
            $companies = new Companies(Uuid::v6());
            $companies->addUser($this->security->getUser());
            $companies->setName($place['name']);
            $companies->setTypes($place['types']);
            ['lat' => $lat, 'lng' => $lng] = $place['geometry']['location'];
            $companies->setLocation(new Location($lat, $lng));
            $em->persist($companies);
            $em->flush();

            $collection->add($companies);
            $this->logger->warning($companies->getId()->toRfc4122());
        }

        return $collection;
    }
}
