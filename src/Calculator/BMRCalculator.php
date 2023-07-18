<?php

declare(strict_types=1);

namespace App\Calculator;

use Exception;

final class BMRCalculator
{
    private const GENDER_MALE = 'male';
    private const GENDER_FEMALE = 'female';

    /* @throws Exception */
    public function calculateBmr(int $weight, int $height, int $age, string $gender): float
    {
        $bmr = 0;
        if ($height <= 0 || $weight <= 0 || $age <= 0) {
            throw new Exception('Invalid input');
        }

        if ($gender === self::GENDER_MALE) {
            $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age) + 5;
            return max(round($bmr, 0), 1500);
        } elseif ($gender === self::GENDER_FEMALE) {
            $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age) - 161;
            return max(round($bmr, 0), 1200);
        }

        return round($bmr, 0);
    }

    /* @throws Exception */
    public function calculateBmrWithActivity(int $weight, int $height, int $age, string $gender, float $exerciseCurrent): float
    {
        $bmrWithActivity = match ($exerciseCurrent) {
            // exerciseCurrent: none
            0.0 => $this->calculateBmr($weight, $height, $age, $gender) * 1.2,
            // exerciseCurrent: 1-2 times a week
            0.5 => $this->calculateBmr($weight, $height, $age, $gender) * 1.375,
            // exerciseCurrent: 3-5 times a week
            1.0 => $this->calculateBmr($weight, $height, $age, $gender) * 1.55,
            default => $this->calculateBmr($weight, $height, $age, $gender),
        };

        return round($bmrWithActivity, 0);
    }
}
