<?php

namespace App\Entity;

use App\Enum\BmiCategory;
use App\Enum\Gender;
use App\Enum\PhysicalActivityLevel;
use App\Repository\BmiRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BmiRepository::class)]
class Bmi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'bmi', targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $mass = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $height = null;

    #[ORM\Column]
    private ?int $age = null;

    #[ORM\Column(enumType: Gender::class)]
    private ?Gender $gender = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $bmiValue = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $calculatedAt = null;

    #[ORM\Column(enumType: PhysicalActivityLevel::class)]
    private ?PhysicalActivityLevel $activityLevel = PhysicalActivityLevel::Moderate;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getMass(): ?string
    {
        return $this->mass;
    }

    public function setMass(string $mass): static
    {
        $this->mass = $mass;
        return $this;
    }

    public function getHeight(): ?string
    {
        return $this->height;
    }

    public function setHeight(string $height): static
    {
        $this->height = $height;
        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;
        return $this;
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(Gender $gender): static
    {
        $this->gender = $gender;
        return $this;
    }

    public function getBmiValue(): ?string
    {
        return $this->bmiValue;
    }

    public function setBmiValue(string $bmiValue): static
    {
        $this->bmiValue = $bmiValue;
        return $this;
    }

    public function getCalculatedAt(): ?\DateTimeImmutable
    {
        return $this->calculatedAt;
    }

    public function setCalculatedAt(\DateTimeImmutable $calculatedAt): static
    {
        $this->calculatedAt = $calculatedAt;
        return $this;
    }

    public function getCategory(): BmiCategory
    {
        $bmi = (float) $this->bmiValue;

        return match (true) {
            $bmi < 18.5 => BmiCategory::Underweight,
            $bmi < 25   => BmiCategory::Normal,
            $bmi < 30   => BmiCategory::Overweight,
            default     => BmiCategory::Obese,
        };
    }

    public function getActivityLevel(): ?PhysicalActivityLevel
    {
        return $this->activityLevel;
    }

    public function setActivityLevel(PhysicalActivityLevel $activityLevel): static
    {
        $this->activityLevel = $activityLevel;
        return $this;
    }

    public function estimateCalories(): int
    {
        if (!$this->activityLevel || !$this->gender) return 0;

        $weight = (float) $this->mass;
        $height = (float) $this->height;
        $age = (int) $this->age;

        $bmr = match ($this->gender->value) {
            'female' => 10 * $weight + 6.25 * $height - 5 * $age - 161,
            'male' => 10 * $weight + 6.25 * $height - 5 * $age + 5,
            default => 0
        };

        return (int) round($bmr * $this->activityLevel->factor());
    }
}
