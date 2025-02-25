<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
#[UniqueEntity('Title')]
#[UniqueEntity('slug')]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 5, groups: ['Extra'])]
    #[BanWord(groups:['Extra'])]
    private ?string $Title = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank()]
    #[Assert\Positive()]
    #[Assert\LessThan(value: 1440)]
    private ?int $duration = null;

    #[ORM\Column(nullable: true)]
    private ?int $glucidesByGame = null;

    #[ORM\Column(nullable: true)]
    private ?int $ProteinesByGame = null;

    #[ORM\Column(nullable: true)]
    private ?int $graissesByGame = null;

    #[ORM\Column(nullable: true)]
    private ?int $kcal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getGlucidesByGame(): ?int
    {
        return $this->glucidesByGame;
    }

    public function setGlucidesByGame(?int $glucidesByGame): static
    {
        $this->glucidesByGame = $glucidesByGame;

        return $this;
    }

    public function getProteinesByGame(): ?int
    {
        return $this->ProteinesByGame;
    }

    public function setProteinesByGame(?int $ProteinesByGame): static
    {
        $this->ProteinesByGame = $ProteinesByGame;

        return $this;
    }

    public function getGraissesByGame(): ?int
    {
        return $this->graissesByGame;
    }

    public function setGraissesByGame(?int $graissesByGame): static
    {
        $this->graissesByGame = $graissesByGame;

        return $this;
    }

    public function getKcal(): ?int
    {
        return $this->kcal;
    }

    public function setKcal(?int $kcal): static
    {
        $this->kcal = $kcal;

        return $this;
    }
}
