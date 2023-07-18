<?php

declare(strict_types=1);

namespace App\StateProvider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\BodyCheck;
use App\Client\RedisClient;

class RedisBodyCheckProvider implements ProviderInterface
{
    public function __construct(private RedisClient $redisClient)
    {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $bodyCheckId = BodyCheck::BODY_CHECK_PREFIX . $uriVariables['bodyCheckId'];

        $data = json_decode($this->redisClient->getData($bodyCheckId), true);

        $bodyCheck = new BodyCheck();
        $bodyCheck->setBodyCheckId($uriVariables['bodyCheckId']);
        $bodyCheck->setBodyCheckData($data['bodyCheckData']);

        return $bodyCheck;
    }
}
