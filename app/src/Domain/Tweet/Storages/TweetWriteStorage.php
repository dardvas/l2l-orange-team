<?php

declare(strict_types=1);

namespace App\Domain\Tweet\Storages;

use App\Application\Db\AbstractStorage;

class TweetWriteStorage extends AbstractStorage
{
    public function insertNewTweet(int $userId, string $message, int $createdAtTimestamp): int
    {
        $statement = $this->pdo->prepare(<<<SQL
            INSERT INTO {$this->getTableName()}
                (id, user_id, message, created_at_timestamp) VALUE
                (null, :user_id, :message, :created_at_timestamp)
        SQL);

        $statement->bindParam(':user_id', $userId);
        $statement->bindParam(':message', $message);
        $statement->bindParam(':created_at_timestamp', $createdAtTimestamp);

        $statement->execute();

        return (int) $this->pdo->lastInsertId();
    }

    protected function getTableName()
    {
        return 'tweets';
    }
}
