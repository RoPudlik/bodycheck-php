<?php

declare(strict_types=1);

namespace App\Client;

use Predis\Client;

class RedisClient
{
    public function __construct(private Client $redis)
    {}

    public function getData($key)
    {
        return $this->redis->get($key);
    }

    public function setData($key, $value)
    {
        return $this->redis->set($key, $value);
    }
}
