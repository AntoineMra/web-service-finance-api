<?php

namespace App\Entity;

use App\Entity\Transaction;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Enum\BudgetStatus;
use App\Repository\BudgetRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation\Timestampable;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: BudgetRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new Put(),
        new Delete(),
        new GetCollection(),
        new Post(),
    ],
    normalizationContext: ['groups' => ['budget:read']],
    denormalizationContext: ['groups' => ['budget:write']]
)] class Budget
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['budget:read', 'budget:write'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['budget:read', 'budget:write'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255, enumType: BudgetStatus::class, nullable: true)]
    #[Groups(['budget:read', 'budget:write'])]
    private ?BudgetStatus $status = null;

    #[ORM\OneToMany(mappedBy: 'budget', targetEntity: Transaction::class, orphanRemoval: true)]
    #[Groups('budget:read')]
    private Collection $transactions;

    /**
     * @Timestampable(on="create")
     */
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups('budget:read')]
    private \DateTime $createdAt;



    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return date_format($this->date, "mmYY");
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions->add($transaction);
            $transaction->setBudget($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            if ($transaction->getBudget() === $this) {
                $transaction->setBudget(null);
            }
        }

        return $this;
    }
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
}
