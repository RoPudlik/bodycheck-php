<?php

namespace App\Security;

use App\Client\RedisClient;
use App\Entity\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class RedisUserProvider implements UserProviderInterface
{
    public function __construct(private RedisClient $redis)
    {}

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $userIdentifier = User::USER_PREFIX . $identifier;

        $userData = $this->redis->getData($userIdentifier);

        if (!$userData) {
            throw new UserNotFoundException();
        }

        $userData = json_decode($userData, true);

        $user = new User();
        $user->setEmail($userData['email']);
        $user->setPassword($userData['password']);

        return $user;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        return $this->loadUserByIdentifier($user->getId());
    }

    public function supportsClass($class): bool
    {
        return $class === User::class;
    }
}
