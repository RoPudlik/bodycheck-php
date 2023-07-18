<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Serializer\Annotation\Groups;

class BodyCheckOutput
{
    /** @Groups("read") */
    public float $proteinNeed;

    /** @Groups("read") */
    public float $bmiScore;

    /** @Groups("read") */
    public array $bmr;

    /** @Groups("read") */
    public float $waterIntake;
}
