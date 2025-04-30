<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\Column(type: 'text')]
    private ?string $ingredients = null;

    #[ORM\Column(type: 'integer')]
    private int $preparationTime;

    #[ORM\Column(type: 'integer')]
    private int $calories;

    #[ORM\Column(type: 'boolean')]
    private bool $isVegetarian = false;

    #[ORM\Column(type: 'boolean')]
    private bool $isVegan = false;

    #[ORM\Column(type: 'text')]
    private string $allergens;

    #[ORM\Column(type: 'text')]
    private string $nutrients;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $externalLink = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'recipes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $createdBy = null;

    #[ORM\Column(type: 'boolean')]
    private bool $approvedByAdmin = false;

    #[ORM\Column(type: 'float')]
    private float $averageRating = 0;

    #[ORM\Column(type: 'boolean')]
    private bool $isApproved = false;

    public function isApproved(): bool
    {
        return $this->isApproved;
    }

    public function setIsApproved(bool $isApproved): self
    {
        $this->isApproved = $isApproved;
        return $this;
    }

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: RecipeRating::class, orphanRemoval: true)]
    private Collection $recipeRatings;

    public function __construct()
    {
        $this->recipeRatings = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getIngredients(): ?string
    {
        return $this->ingredients;
    }
    public function setIngredients(string $ingredients): self
    {
        $this->ingredients = $ingredients;
        return $this;
    }

    public function getPreparationTime(): int
    {
        return $this->preparationTime;
    }
    public function setPreparationTime(int $preparationTime): self
    {
        $this->preparationTime = $preparationTime;
        return $this;
    }

    public function getCalories(): int
    {
        return $this->calories;
    }
    public function setCalories(int $calories): self
    {
        $this->calories = $calories;
        return $this;
    }

    public function isVegetarian(): bool
    {
        return $this->isVegetarian;
    }
    public function setIsVegetarian(bool $isVegetarian): self
    {
        $this->isVegetarian = $isVegetarian;
        return $this;
    }

    public function isVegan(): bool
    {
        return $this->isVegan;
    }
    public function setIsVegan(bool $isVegan): self
    {
        $this->isVegan = $isVegan;
        return $this;
    }

    public function getAllergens(): string
    {
        return $this->allergens;
    }
    public function setAllergens(string $allergens): self
    {
        $this->allergens = $allergens;
        return $this;
    }

    public function getNutrients(): string
    {
        return $this->nutrients;
    }
    public function setNutrients(string $nutrients): self
    {
        $this->nutrients = $nutrients;
        return $this;
    }

    public function getExternalLink(): ?string
    {
        return $this->externalLink;
    }
    public function setExternalLink(?string $externalLink): self
    {
        $this->externalLink = $externalLink;
        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }
    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    public function isApprovedByAdmin(): bool
    {
        return $this->approvedByAdmin;
    }
    public function setApprovedByAdmin(bool $approvedByAdmin): self
    {
        $this->approvedByAdmin = $approvedByAdmin;
        return $this;
    }

    public function getAverageRating(): float
    {
        return $this->averageRating;
    }
    public function setAverageRating(float $averageRating): self
    {
        $this->averageRating = $averageRating;
        return $this;
    }

    public function getRecipeRatings(): Collection
    {
        return $this->recipeRatings;
    }
    public function addRecipeRating(RecipeRating $recipeRating): self
    {
        if (!$this->recipeRatings->contains($recipeRating)) {
            $this->recipeRatings[] = $recipeRating;
            $recipeRating->setRecipe($this);
        }
        return $this;
    }
    public function removeRecipeRating(RecipeRating $recipeRating): self
    {
        if ($this->recipeRatings->removeElement($recipeRating)) {
            if ($recipeRating->getRecipe() === $this) {
                $recipeRating->setRecipe(null);
            }
        }
        return $this;
    }
}
