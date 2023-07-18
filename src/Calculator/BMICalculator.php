<?php

declare(strict_types=1);

namespace App\Calculator;

use Exception;

final class BMICalculator
{
    /**
     * @throws Exception
     */
    public function calculateBmi(int $height, int $weight): float
    {
        if ($height <= 0 || $weight <= 0) {
            throw new Exception('Invalid input: height or weight has to be more than 0');
        }
        return round($weight / ($height/100)**2, 1);

    }
}
