<?php

namespace App\Entity;

use App\Repository\InvestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvestRepository::class)]
class Invest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $support = null;

    #[ORM\Column]
    private ?float $expectedReturn = null;

    #[ORM\Column]
    private ?int $monthlyInvestment = null;

    #[ORM\Column(length: 255)]
    private ?string $specificCondition = null;

    #[ORM\Column]
    private ?float $currentAmount = null;

    #[ORM\Column]
    private ?int $initialAmount = null;

    #[ORM\ManyToMany(targetEntity: Goal::class, mappedBy: 'investments')]
    private Collection $goals;

    public function __construct()
    {
        $this->goals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSupport(): ?string
    {
        return $this->support;
    }

    public function setSupport(string $support): self
    {
        $this->support = $support;

        return $this;
    }

    public function getExpectedReturn(): ?float
    {
        return $this->expectedReturn;
    }

    public function setExpectedReturn(float $expectedReturn): self
    {
        $this->expectedReturn = $expectedReturn;

        return $this;
    }

    public function getMonthlyInvestment(): ?int
    {
        return $this->monthlyInvestment;
    }

    public function setMonthlyInvestment(int $monthlyInvestment): self
    {
        $this->monthlyInvestment = $monthlyInvestment;

        return $this;
    }

    public function getSpecificCondition(): ?string
    {
        return $this->specificCondition;
    }

    public function setSpecificCondition(string $specificCondition): self
    {
        $this->specificCondition = $specificCondition;

        return $this;
    }

    public function getCurrentAmount(): ?float
    {
        return $this->currentAmount;
    }

    public function setCurrentAmount(float $currentAmount): self
    {
        $this->currentAmount = $currentAmount;

        return $this;
    }

    public function getInitialAmount(): ?int
    {
        return $this->initialAmount;
    }

    public function setInitialAmount(int $initialAmount): self
    {
        $this->initialAmount = $initialAmount;

        return $this;
    }

    /**
     * @return Collection<int, Goal>
     */
    public function getGoals(): Collection
    {
        return $this->goals;
    }

    public function addGoal(Goal $goal): self
    {
        if (!$this->goals->contains($goal)) {
            $this->goals->add($goal);
            $goal->addInvestment($this);
        }

        return $this;
    }

    public function removeGoal(Goal $goal): self
    {
        if ($this->goals->removeElement($goal)) {
            $goal->removeInvestment($this);
        }

        return $this;
    }
}
