<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\StocksRepository;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StocksRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
    ],
    normalizationContext: ['groups' => ['stocks:read']],
    denormalizationContext: ['groups' => ['stocks:write']]
)]
class Stocks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('stocks:read')]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('stocks:read')]
    private ?string $symbol = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('stocks:read')]
    private ?string $url = null;

    #[ORM\Column]
    #[Groups('stocks:read')]
    private ?bool $isAcknowledged = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(?string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function isIsAcknowledged(): ?bool
    {
        return $this->isAcknowledged;
    }

    public function setIsAcknowledged(bool $isAcknowledged): self
    {
        $this->isAcknowledged = $isAcknowledged;

        return $this;
    }
}
