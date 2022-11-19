<?php

declare(strict_types=1);

namespace App\Domain\Subscription\Services;

use App\Domain\Subscription\Storages\SubscriptionReadStorage;
use App\Domain\Subscription\Storages\SubscriptionsWriteStorage;

class SubscriptionService
{
    private SubscriptionReadStorage $subscriptionReadStorage;
    private SubscriptionsWriteStorage $subscriptionsWriteStorage;

    public function __construct(
        SubscriptionReadStorage $subscriptionReadStorage,
        SubscriptionsWriteStorage $subscriptionsWriteStorage
    ) {
        $this->subscriptionReadStorage = $subscriptionReadStorage;
        $this->subscriptionsWriteStorage = $subscriptionsWriteStorage;
    }

    public function subscribe(int $publisherId, int $subscriberId): void
    {
        $this->subscriptionsWriteStorage->insertNewSubscription($publisherId, $subscriberId);
    }

    public function isSubscribed(int $subscriberId, int $publisherId): bool
    {
        $subscription = $this->subscriptionReadStorage->findSubscription($subscriberId, $publisherId);

        return $subscription !== null;
    }
}
