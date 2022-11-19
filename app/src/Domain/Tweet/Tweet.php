<?php

declare(strict_types=1);

namespace App\Domain\Tweet;

use JsonSerializable;

class Tweet implements JsonSerializable
{
    private int $id;
    private int $userId;
    private string $message;
    private int $createdAtTimestamp;

    public function __construct(int $id, int $userId, string $message, int $createdAtTimestamp)
    {
        $this->id = $id;
        $this->message = $message;
        $this->createdAtTimestamp = $createdAtTimestamp;
        $this->userId = $userId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCreatedAtTimestamp(): int
    {
        return $this->createdAtTimestamp;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'message' => $this->message,
            'created_at_timestamp' => $this->createdAtTimestamp,
        ];
    }
}
