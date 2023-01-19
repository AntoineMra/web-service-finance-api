<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LocationRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private ?Uuid $id;

    #[ORM\Column]
    #[Groups(['company:read', 'company:write', 'user:read', 'user:write'])]
    private ?float $lat = null;

    #[ORM\Column]
    #[Groups(['company:read', 'company:write', 'user:read', 'user:write'])]
    private ?float $long = null;

    #[ORM\OneToOne(mappedBy: 'location', cascade: ['persist', 'remove'])]
    private ?Companies $companies = null;

    public function __construct($lat = 0, $long = 0)
    {
        $this->id = $id ?? Uuid::v6();
        $this->lat = $lat;
        $this->long = $long;
    }

    public function getId(): ?Uuid
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

    #[Groups(['company:read', 'company:write', 'user:read', 'user:write'])]
    public function getFullLocation(): string
    {
        return strval($this->long) . ', ' . strval($this->lat);
    }
}
