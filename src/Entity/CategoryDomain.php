<?php

namespace App\Entity;

use App\Repository\CategoryDomainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryDomainRepository::class)]
class CategoryDomain
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\OneToMany(mappedBy: 'categoryDomain', targetEntity: Categorie::class, orphanRemoval: true)]
    private Collection $caategories;

    public function __construct()
    {
        $this->caategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCaategories(): Collection
    {
        return $this->caategories;
    }

    public function addCaategory(Categorie $caategory): self
    {
        if (!$this->caategories->contains($caategory)) {
            $this->caategories->add($caategory);
            $caategory->setCategoryDomain($this);
        }

        return $this;
    }

    public function removeCaategory(Categorie $caategory): self
    {
        if ($this->caategories->removeElement($caategory)) {
            // set the owning side to null (unless already changed)
            if ($caategory->getCategoryDomain() === $this) {
                $caategory->setCategoryDomain(null);
            }
        }

        return $this;
    }
}
