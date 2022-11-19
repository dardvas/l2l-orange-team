<?php

declare(strict_types=1);

namespace App\Domain\Feed;

class FeedConfig
{
    private int $tweetsPerPage;

    public function __construct(int $tweetsPerPage)
    {
        $this->tweetsPerPage = $tweetsPerPage;
    }

    public function getTweetsPerPage(): int
    {
        return $this->tweetsPerPage;
    }
}
