<?php

namespace App\Entity;

use App\Repository\GoalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GoalRepository::class)]
class Goal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $expectedEnding = null;

    #[ORM\ManyToMany(targetEntity: Invest::class, inversedBy: 'goals')]
    private Collection $investments;

    public function __construct()
    {
        $this->investments = new ArrayCollection();
    }

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

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getExpectedEnding(): ?\DateTimeInterface
    {
        return $this->expectedEnding;
    }

    public function setExpectedEnding(\DateTimeInterface $expectedEnding): self
    {
        $this->expectedEnding = $expectedEnding;

        return $this;
    }

    /**
     * @return Collection<int, Invest>
     */
    public function getInvestments(): Collection
    {
        return $this->investments;
    }

    public function addInvestment(Invest $investment): self
    {
        if (!$this->investments->contains($investment)) {
            $this->investments->add($investment);
        }

        return $this;
    }

    public function removeInvestment(Invest $investment): self
    {
        $this->investments->removeElement($investment);

        return $this;
    }
}
