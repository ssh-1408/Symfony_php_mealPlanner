<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\Entity\Bmi;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $username = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles;

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isBlocked;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: RecipeRating::class, orphanRemoval: true)]
    private Collection $recipeRatings;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: MealPlan::class, orphanRemoval: true)]
    private Collection $mealPlans;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Recipe::class, orphanRemoval: true)]
    private Collection $recipes;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Bmi::class, cascade: ['persist', 'remove'])]
    private ?Bmi $bmi = null;

    public function __construct()
    {
        $this->roles = [];
        $this->isBlocked = false;
        $this->recipeRatings = new ArrayCollection();
        $this->mealPlans = new ArrayCollection();
        $this->recipes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }
    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function isBlocked(): bool
    {
        return $this->isBlocked;
    }
    public function setIsBlocked(bool $isBlocked): self
    {
        $this->isBlocked = $isBlocked;
        return $this;
    }

    public function eraseCredentials(): void {}

    public function getRecipeRatings(): Collection
    {
        return $this->recipeRatings;
    }
    public function addRecipeRating(RecipeRating $recipeRating): self
    {
        if (!$this->recipeRatings->contains($recipeRating)) {
            $this->recipeRatings[] = $recipeRating;
            $recipeRating->setUser($this);
        }
        return $this;
    }
    public function removeRecipeRating(RecipeRating $recipeRating): self
    {
        if ($this->recipeRatings->removeElement($recipeRating)) {
            if ($recipeRating->getUser() === $this) {
                $recipeRating->setUser(null);
            }
        }
        return $this;
    }

    public function getMealPlans(): Collection
    {
        return $this->mealPlans;
    }
    public function addMealPlan(MealPlan $mealPlan): self
    {
        if (!$this->mealPlans->contains($mealPlan)) {
            $this->mealPlans[] = $mealPlan;
            $mealPlan->setUser($this);
        }
        return $this;
    }
    public function removeMealPlan(MealPlan $mealPlan): self
    {
        if ($this->mealPlans->removeElement($mealPlan)) {
            if ($mealPlan->getUser() === $this) {
                $mealPlan->setUser(null);
            }
        }
        return $this;
    }

    public function getRecipes(): Collection
    {
        return $this->recipes;
    }
    public function addRecipe(Recipe $recipe): self
    {
        if (!$this->recipes->contains($recipe)) {
            $this->recipes[] = $recipe;
            $recipe->setCreatedBy($this);
        }
        return $this;
    }
    public function removeRecipe(Recipe $recipe): self
    {
        if ($this->recipes->removeElement($recipe)) {
            if ($recipe->getCreatedBy() === $this) {
                $recipe->setCreatedBy(null);
            }
        }
        return $this;
    }

    public function getBmi(): ?Bmi
    {
        return $this->bmi;
    }

    public function setBmi(?Bmi $bmi): self
    {
        $this->bmi = $bmi;

        // Ensure the owning side is set
        if ($bmi !== null && $bmi->getUser() !== $this) {
            $bmi->setUser($this);
        }

        return $this;
    }
}
