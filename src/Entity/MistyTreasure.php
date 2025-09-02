<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Repository\MistyTreasureRepository;
use Carbon\Carbon;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: MistyTreasureRepository::class)]
#[ApiResource(
    shortName: 'Treasure',
    paginationItemsPerPage: 10,
)]
#[ApiFilter(SearchFilter::class, properties: [
    'owner.username' => 'partial',
])]
#[ApiResource(
    uriTemplate: '/users/{user_id}/treasures.{_format}',
    shortName: 'Treasure',
    operations: [new GetCollection()],
    uriVariables: [
        'user_id' => new Link(
            fromProperty: 'mistyTreasures',
            fromClass: User::class,
        ),
    ],
    normalizationContext: ['groups' => ['treasure:read']],
)]
class MistyTreasure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    #[Groups(['user:read'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $value = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeInterface $plunderedAt;

    #[ORM\ManyToOne(inversedBy: 'mistyTreasures')]
    #[ORM\JoinColumn(nullable: false)]
    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
    private ?User $owner = null;

    public function __construct(){
        $this->plunderedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): static
    {
        $this->value = $value;

        return $this;
    }
    public function getPlunderedAt(): ?\DateTimeImmutable
    {
        return $this->plunderedAt;
    }

    /**
     * A human-readable representation of when this treasure was plundered.
     */
    public function getPlunderedAtAgo(): string
    {
        return Carbon::instance($this->plunderedAt)->diffForHumans();
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }
}
