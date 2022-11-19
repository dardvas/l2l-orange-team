<?php

declare(strict_types=1);

namespace App\Domain\Tweet\Storages;

use App\Application\Db\AbstractStorage;
use App\Domain\Tweet\Tweet;
use PDO;

class TweetReadStorage extends AbstractStorage
{
    /**
     * @param int $userId
     * @return Tweet[]
     */
    public function getTweetsByUserId(int $userId, int $limit = self::DEFAULT_QUERY_LIMIT): array
    {
        $this->validatePositiveInt($userId);

        $st = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE user_id=:user_id LIMIT $limit");
        $st->bindParam(':user_id', $userId);
        $st->execute();

        $tweetRows = $st->fetchAll(PDO::FETCH_ASSOC);

        $tweets = [];
        foreach ($tweetRows as $tweetRow) {
            $tweets[] = new Tweet(
                (int) $tweetRow['id'],
                (int) $tweetRow['user_id'],
                $tweetRow['message'],
                (int) $tweetRow['created_at_timestamp'],
            );
        }

        return $tweets;
    }

    /**
     * @param array $excludeUserIds
     * @param int $limit
     * @return int[]
     */
    public function getRandomUsersWithTweetsIdsExcludeGiven(array $excludeUserIds, int $limit = self::DEFAULT_QUERY_LIMIT): array
    {
        foreach ($excludeUserIds as $userId) {
            $this->validatePositiveInt($userId);
        }
        $qMarks = str_repeat('?,', count($excludeUserIds) - 1) . '?';

        $st = $this->pdo->prepare(<<<SQL
            SELECT DISTINCT user_id FROM {$this->getTableName()}
            WHERE user_id NOT IN ({$qMarks})
            ORDER BY RAND()
            LIMIT $limit 
        SQL);
        $st->execute($excludeUserIds);

        return array_map(
            static fn($idStr) => (int) $idStr,
            $st->fetchAll(PDO::FETCH_COLUMN)
        );
    }

    /**
     * @param array $userIds
     * @param int $tweetsPerUser
     * @return Tweet[]
     */
    public function getLastUserTweets(array $userIds, int $tweetsPerUser = self::DEFAULT_QUERY_LIMIT): array
    {
        $unionQueryParts = [];

        foreach ($userIds as $bindNum => $userId) {
            $this->validatePositiveInt($userId);

            $unionQueryParts[] = <<<SQL
                (SELECT * FROM {$this->getTableName()}
                WHERE user_id = {$userId}
                ORDER BY created_at_timestamp
                LIMIT $tweetsPerUser)
            SQL;
        }

        $st = $this->pdo->prepare(implode(' UNION ', $unionQueryParts));
        $st->execute();

        $tweetRows = $st->fetchAll(PDO::FETCH_ASSOC);

        $tweets = [];
        foreach ($tweetRows as $tweetRow) {
            $tweets[(int) $tweetRow['user_id']] = new Tweet(
                (int) $tweetRow['id'],
                (int) $tweetRow['user_id'],
                $tweetRow['message'],
                (int) $tweetRow['created_at_timestamp'],
            );
        }

        return $tweets;
    }

    protected function getTableName()
    {
        return 'tweets';
    }
}
