<?php

// src/Enum/Mealtime.php
namespace App\Enum;

enum Mealtime: string
{
    case BREAKFAST = 'breakfast';
    case LUNCH = 'lunch';
    case DINNER = 'dinner';
    case SUPPER = 'supper';
}
