<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\ManyToOne(inversedBy: 'caategories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategoryDomain $categoryDomain = null;

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

    public function getCategoryDomain(): ?CategoryDomain
    {
        return $this->categoryDomain;
    }

    public function setCategoryDomain(?CategoryDomain $categoryDomain): self
    {
        $this->categoryDomain = $categoryDomain;

        return $this;
    }
}
