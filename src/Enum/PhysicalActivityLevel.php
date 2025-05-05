<?php

// src/Enum/PhysicalActivityLevel.php

namespace App\Enum;

enum PhysicalActivityLevel: string
{
    case Sedentary = 'sedentary';
    case Light = 'light';
    case Moderate = 'moderate';
    case Active = 'active';
    case VeryActive = 'very_active';

    public function label(): string
    {
        return match ($this) {
            self::Sedentary => 'Sedentary (little or no exercise)',
            self::Light => 'Light (light exercise/sports 1–3 days/week)',
            self::Moderate => 'Moderate (moderate exercise/sports 3–5 days/week)',
            self::Active => 'Active (hard exercise/sports 6–7 days/week)',
            self::VeryActive => 'Very Active (very hard exercise, physical job, or training)',
        };
    }

    public function factor(): float
    {
        return match ($this) {
            self::Sedentary => 1.2,
            self::Light => 1.375,
            self::Moderate => 1.55,
            self::Active => 1.725,
            self::VeryActive => 1.9,
        };
    }
}
