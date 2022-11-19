<?php

declare(strict_types=1);

namespace App\Domain\Tweet\Services;

use App\Domain\Feed\FeedConfig;
use App\Domain\Tweet\Storages\TweetReadStorage;
use App\Domain\Tweet\Storages\TweetWriteStorage;
use App\Domain\Tweet\Tweet;

class TweetService
{
    private TweetReadStorage $tweetReadStorage;
    private TweetWriteStorage $tweetWriteStorage;
    private FeedConfig $feedConfig;

    public function __construct(
        TweetReadStorage $tweetReadStorage,
        TweetWriteStorage $tweetWriteStorage,
        FeedConfig $feedConfig
    )
    {
        $this->tweetReadStorage = $tweetReadStorage;
        $this->tweetWriteStorage = $tweetWriteStorage;
        $this->feedConfig = $feedConfig;
    }

    public function createNewTweet(int $userId, string $message): int
    {
        $createdAtTimestamp = time();

        // invalidate $feedTweets cache by $userId

        return $this->tweetWriteStorage->insertNewTweet($userId, $message, $createdAtTimestamp);
    }

    public function getTweetsSerializedForFeed(int $feedOwnerId): array
    {
        $tweetsPerPage = $this->feedConfig->getTweetsPerPage();
        $feedTweets = $this->tweetReadStorage->getTweetsByUserId($feedOwnerId, $tweetsPerPage);

        // Here we may cache $feedTweets by $feedOwnerId.$tweetsPerPage and invalidate it
        // when a new tweet is posted to the given user's feed

        return array_map(static fn(Tweet $tweet) => $tweet->jsonSerialize(), $feedTweets);
    }
}
