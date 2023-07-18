<?php

declare(strict_types=1);

namespace App\Calculator;

use Exception;

final class WaterIntakeCalculator
{
    /**
     * @throws Exception
     */
    public function calculateWaterIntake(int $weight, ?float $exerciseCurrentDuration): float
    {
        $waterIntake = $weight * 0.033;

        if (isset($exerciseCurrentDuration)) {
            $waterIntake += $exerciseCurrentDuration;
        }

        if ($waterIntake > 4) {
            $waterIntake = 4;
        }
        return round($waterIntake, 1);
    }
}
