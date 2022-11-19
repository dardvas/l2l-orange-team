<?php

declare(strict_types=1);

namespace App\Domain\Subscription\Storages;

use App\Application\Db\AbstractStorage;
use App\Domain\Subscription\Subscription;
use PDO;

class SubscriptionReadStorage extends AbstractStorage
{
    public function findSubscription(int $subscriberId, int $publisherId): ?Subscription
    {
        $st = $this->pdo->prepare(<<<SQL
            SELECT * FROM {$this->getTableName()}
                WHERE publisher_id=:publisher_id
                    AND subscriber_id=:subscriber_id
        SQL);
        $st->bindParam(':publisher_id', $publisherId);
        $st->bindParam(':subscriber_id', $subscriberId);
        $st->execute();

        $subscriptionRow = $st->fetch(PDO::FETCH_ASSOC);
        if ($subscriptionRow === false) {
            return null;
        }

        return new Subscription(
            (int) $subscriptionRow['publisher_id'],
            (int) $subscriptionRow['subscriber_id']
        );

    }

    protected function getTableName()
    {
        return 'subscriptions';
    }
}
