<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\DTO\BodyCheckOutput;
use App\StateProcessor\BodyCheckProcessor;
use App\StateProvider\BodyCheckOutputProvider;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Get(output: BodyCheckOutput::class, provider: BodyCheckOutputProvider::class),
        new Post(security: "is_granted('ROLE_USER')", processor: BodyCheckProcessor::class),
    ],
    formats: ['json' => ['application/json']],
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
)]
class BodyCheck
{
    public const BODY_CHECK_PREFIX = 'bodyCheck_';

    /**
     * @Groups({"read", "write"})
     */
    #[ApiProperty(identifier: true)]
    protected string $bodyCheckId;

    /**
     * @Groups({"read", "write"})
     */
    #[ApiProperty(
        openapiContext: [
            'type' => 'array',
            'items' => [
                'type' => 'object',
                'properties' => [
                    'weight' => ['type' => 'integer'],
                    'height' => ['type' => 'integer'],
                    'age' => ['type' => 'integer'],
                    'gender' => ['type' => 'string'],
                    'exerciseCurrent' => ['type' => 'number'],
                    'exerciseCurrentDuration' => ['type' => 'number'],
                    'email' => ['type' => 'string']
                ]
            ],
            'example' => [
                'weight' => 'int',
                'height' => 'int',
                'age' => 'int',
                'gender' => 'string',
                'exerciseCurrent' => 'float',
                'exerciseCurrentDuration' => 'float',
                'email' => 'string'
            ]
        ]
    )]
    protected array $bodyCheckData;

    /**
     * @return string
     */
    public function getBodyCheckId(): string
    {
        return $this->bodyCheckId;
    }

    /**
     * @param string $bodyCheckId
     */
    public function setBodyCheckId(string $bodyCheckId): void
    {
        $this->bodyCheckId = $bodyCheckId;
    }

    public function getBodyCheckData(): array
    {
        return $this->bodyCheckData;
    }

    public function setBodyCheckData(array $bodyCheckData): void
    {
        $this->bodyCheckData = $bodyCheckData;
    }
}
