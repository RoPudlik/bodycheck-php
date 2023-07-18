<?php

namespace App\DataFixtures;

use App\Client\RedisClient;
use App\Entity\BodyCheck;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class BodyCheckFixture
{
    private const USER_ID = '12345';

    public function __construct(
        private RedisClient $redisClient,
        private SerializerInterface $serializer
    ) {}

    public function load(): void
    {
        $bodyCheck = new BodyCheck();
        $bodyCheck->setBodyCheckId(self::USER_ID);

        $bodyCheckData = [
            'weight' => 65,
            'height' => 183,
            'age' => 22,
            'gender' => 'male',
            'exerciseCurrent' => 0.5,
            'exerciseCurrentDuration' => 0.5,
            'email' => 'test@example.com'
        ];

        $bodyCheck->setBodyCheckData($bodyCheckData);

        $encodedData = $this->serializer->serialize($bodyCheck, JsonEncoder::FORMAT);

        $this->redisClient->setData(BodyCheck::BODY_CHECK_PREFIX . self::USER_ID, $encodedData);
    }
}
