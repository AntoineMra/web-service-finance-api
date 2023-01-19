<?php

namespace App\Entity;

use App\Entity\Transaction;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Enum\BudgetStatus;
use App\Repository\BudgetRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation\Timestampable;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BudgetRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new Put(),
        new Delete(),
        new Get(
            name: 'subtransactions',
            uriTemplate: '/budgets/{id}/transactions',
            normalizationContext: ['groups' => ['budget_transactions:read']],
            denormalizationContext: ['groups' => ['budget_transactions:write']]
        ),
        new GetCollection(),
        new Post(),
    ],
    normalizationContext: ['groups' => ['budget:read']],
)] class Budget
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    #[Groups(['budget:read', 'budget:write'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['budget:read', 'budget:write'])]
    private ?string $date = null;

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
        $this->id = $id ?? Uuid::v6();
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?Uuid
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

    public function getDate(): ?string
    {
        return $this->date;
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
