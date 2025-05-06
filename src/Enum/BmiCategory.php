<?php

namespace App\Enum;

enum BmiCategory: string
{
    case Underweight = 'underweight';
    case Normal = 'normal';
    case Overweight = 'overweight';
    case Obese = 'obese';

    public function label(): string
    {
        return match ($this) {
            self::Underweight => 'Underweight',
            self::Normal => 'Normal',
            self::Overweight => 'Overweight',
            self::Obese => 'Obese',
        };
    }
}
