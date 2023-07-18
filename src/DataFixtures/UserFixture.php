<?php

namespace App\DataFixtures;

use App\Client\RedisClient;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class UserFixture
{
    public function __construct(
        private RedisClient $redisClient,
        private SerializerInterface $serializer,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function load(): void
    {
        $user = new User();
        $user->setId('12345');
        $user->setEmail('test@example.com');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'example'));

        $encodedData = $this->serializer->serialize($user, JsonEncoder::FORMAT);

        $this->redisClient->setData(User::USER_PREFIX . $user->getEmail(), $encodedData);
    }
}
