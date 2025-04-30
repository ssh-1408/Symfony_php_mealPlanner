<?php

namespace App\Entity;

use App\Enum\Mealtime;
use App\Repository\MealPlanRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MealPlanRepository::class)]
class MealPlan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'mealPlans')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Recipe::class, inversedBy: 'mealPlans')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recipe $recipe = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $mealDate = null;

    #[ORM\Column(enumType: Mealtime::class)]
    private ?Mealtime $mealtime = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }
    public function setRecipe(?Recipe $recipe): self
    {
        $this->recipe = $recipe;
        return $this;
    }

    public function getMealDate(): ?\DateTimeInterface
    {
        return $this->mealDate;
    }
    public function setMealDate(\DateTimeInterface $mealDate): self
    {
        $this->mealDate = $mealDate;
        return $this;
    }

    public function getMealtime(): ?Mealtime
    {
        return $this->mealtime;
    }

    public function setMealtime(Mealtime $mealtime): static
    {
        $this->mealtime = $mealtime;

        return $this;
    }
}
