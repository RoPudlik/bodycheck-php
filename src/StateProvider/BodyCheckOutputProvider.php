<?php

declare(strict_types=1);

namespace App\StateProvider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Calculator\BMICalculator;
use App\Calculator\BMRCalculator;
use App\Calculator\ProteinCalculator;
use App\Calculator\WaterIntakeCalculator;
use App\Entity\BodyCheck;
use App\DTO\BodyCheckOutput;
use Webmozart\Assert\Assert;

class BodyCheckOutputProvider implements ProviderInterface
{
    public function __construct(
        private ProviderInterface $itemProvider,
        private ProteinCalculator $proteinCalculator,
        private BMICalculator $BMICalculator,
        private BMRCalculator $BMRCalculator,
        private WaterIntakeCalculator $waterIntakeCalculator,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        /** @var BodyCheck $bodyCheck */
        $bodyCheck = $this->itemProvider->provide($operation, $uriVariables, $context);
        Assert::notNull($bodyCheck);

        $bodyCheckData = $bodyCheck->getBodyCheckData();
        Assert::notNull($bodyCheckData);

        $output = new BodyCheckOutput();
        $output->proteinNeed = $this->proteinCalculator->calculateProtein($bodyCheckData['weight'], $bodyCheckData['exerciseCurrent']);
        $output->bmiScore = $this->BMICalculator->calculateBmi($bodyCheckData['height'], $bodyCheckData['weight']);
        $output->bmr['withActivity'] = $this->BMRCalculator->calculateBmrWithActivity(
            $bodyCheckData['weight'],
            $bodyCheckData['height'],
            $bodyCheckData['age'],
            $bodyCheckData['gender'],
            $bodyCheckData['exerciseCurrent']
        );
        $output->bmr['withoutActivity'] = $this->BMRCalculator->calculateBmr(
            $bodyCheckData['weight'],
            $bodyCheckData['height'],
            $bodyCheckData['age'],
            $bodyCheckData['gender']
        );
        $output->waterIntake = $this->waterIntakeCalculator->calculateWaterIntake($bodyCheckData['weight'], $bodyCheckData['exerciseCurrentDuration']);

        return $output;
    }
}
