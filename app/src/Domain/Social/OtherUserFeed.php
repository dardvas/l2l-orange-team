<?php

declare(strict_types=1);

namespace App\Domain\Social;

use JsonSerializable;

class OtherUserFeed implements JsonSerializable
{
    private string $username;
    private string $feedUrl;
    private string $lastTweetMessage;

    public function __construct(string $username, string $feedUrl, string $lastTweetMessage)
    {
        $this->username = $username;
        $this->feedUrl = $feedUrl;
        $this->lastTweetMessage = $lastTweetMessage;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getFeedUrl(): string
    {
        return $this->feedUrl;
    }

    public function getLastTweetMessage(): string
    {
        return $this->lastTweetMessage;
    }

    public function jsonSerialize(): array
    {
        return [
            'username' => $this->username,
            'feed_url' => $this->feedUrl,
            'last_tweet_message' => $this->lastTweetMessage,
        ];
    }
}
