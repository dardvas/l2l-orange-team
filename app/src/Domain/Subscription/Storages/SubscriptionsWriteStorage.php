<?php

declare(strict_types=1);

namespace App\Domain\Subscription\Storages;

use App\Application\Db\AbstractStorage;

class SubscriptionsWriteStorage extends AbstractStorage
{
    public function insertNewSubscription(int $publisherId, int $subscriberId): int
    {
        $statement = $this->pdo->prepare(<<<SQL
            INSERT INTO {$this->getTableName()}
                (publisher_id, subscriber_id) VALUE
                (:publisher_id, :subscriber_id)
        SQL);

        $statement->bindParam(':publisher_id', $publisherId);
        $statement->bindParam(':subscriber_id', $subscriberId);

        $statement->execute();

        $last = $this->pdo->lastInsertId();

        return 1;
    }

    protected function getTableName()
    {
        return 'subscriptions';
    }
}
