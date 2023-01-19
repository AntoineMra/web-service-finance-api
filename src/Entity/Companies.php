<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Controller\GetCompaniesNearby;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\CompaniesRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CompaniesRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            name: 'nearbyCompanies',
            controller: GetCompaniesNearby::class,
            openapiContext: [
                'summary' => 'Create companies nearby',
                'requestBody' => [
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'long' => ['type' => 'float'],
                                    'lat' => ['type' => 'float']
                                ]
                            ],
                            'example' => [
                                'long' => '151.2100055',
                                'lat' => '-33.8587323'
                            ]
                        ]
                    ]
                ]
            ],
            read: false
        ),
    ],
    normalizationContext: ['groups' => ['company:read']],
    denormalizationContext: ['groups' => ['company:write']],
)]
#[ApiFilter(SearchFilter::class, properties: ['types' => 'partial'])]
class Companies
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups('company:read')]
    private Uuid $id;

    #[ORM\Column(length: 255)]
    #[Groups(['company:read', 'company:write'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::JSON)]
    #[Groups(['company:read', 'company:write'])]
    private array $types = [];

    #[ORM\OneToOne(inversedBy: 'companies', cascade: ['persist', 'remove'])]
    #[Groups(['company:read', 'company:write'])]
    private ?Location $location = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'companies')]
    private Collection $users;

    public function __construct($id = null)
    {
        $this->id = $id ?? Uuid::v6();
        $this->users = new ArrayCollection();
    }

    public function getId(): Uuid
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

    public function getTypes(): array
    {
        return $this->types;
    }

    public function setTypes(array $types): self
    {
        $this->types = $types;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addCompany($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeCompany($this);
        }

        return $this;
    }
}
