<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LocationRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['company:read', 'company:write', 'user:read', 'user:write'])]
    private ?float $lat = null;

    #[ORM\Column]
    #[Groups(['company:read', 'company:write', 'user:read', 'user:write'])]
    private ?float $long = null;

    #[ORM\OneToOne(mappedBy: 'location', cascade: ['persist', 'remove'])]
    private ?Companies $companies = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLong(): ?float
    {
        return $this->long;
    }

    public function setLong(float $long): self
    {
        $this->long = $long;

        return $this;
    }

    public function getCompanies(): ?Companies
    {
        return $this->companies;
    }

    public function setCompanies(?Companies $companies): self
    {
        // unset the owning side of the relation if necessary
        if ($companies === null && $this->companies !== null) {
            $this->companies->setLocation(null);
        }

        // set the owning side of the relation if necessary
        if ($companies !== null && $companies->getLocation() !== $this) {
            $companies->setLocation($this);
        }

        $this->companies = $companies;

        return $this;
    }
}
