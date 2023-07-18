<?php

declare(strict_types=1);

namespace App\StateProcessor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\BodyCheck;
use App\Client\RedisClient;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class BodyCheckProcessor implements ProcessorInterface
{
    public function __construct(
        private RedisClient $redisClient,
        private SerializerInterface $serializer
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if (!$data instanceof BodyCheck) {
            return;
        }

        $bodyCheckId = BodyCheck::BODY_CHECK_PREFIX . $data->getBodyCheckId();

        $encodedData = $this->serializer->serialize($data, JsonEncoder::FORMAT);

        $this->redisClient->setData($bodyCheckId, $encodedData);

    }
}
