<?php

declare(strict_types=1);

namespace App\Calculator;

final class ProteinCalculator
{
    public function calculateProtein(int $weight, float $exerciseCurrent): float
    {
        $protein = match ($exerciseCurrent) {
            0.0 => $weight,
            0.5 => $weight * 1.4,
            1.0 => $weight * 1.8,
            default => 0,
        };

        return round($protein);
    }
}
