<?php

declare(strict_types=1);

namespace App\Domain\Subscription;

class Subscription
{
    private int $publisherId;
    private int $subscriberId;

    public function __construct(int $publisherId, int $subscriberId)
    {
        $this->publisherId = $publisherId;
        $this->subscriberId = $subscriberId;
    }

    public function getPublisherId(): int
    {
        return $this->publisherId;
    }

    public function getSubscriberId(): int
    {
        return $this->subscriberId;
    }
}
