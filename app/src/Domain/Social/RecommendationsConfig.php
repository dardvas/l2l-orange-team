<?php

declare(strict_types=1);

namespace App\Domain\Social;

class RecommendationsConfig
{
    private int $sidebarOtherUserFeedsCount;
    private int $sidebarTweetsPerUser;

    public function __construct(int $sidebarOtherUserFeedsCount, int $sidebarTweetsPerUser)
    {
        $this->sidebarOtherUserFeedsCount = $sidebarOtherUserFeedsCount;
        $this->sidebarTweetsPerUser = $sidebarTweetsPerUser;
    }

    public function getSidebarOtherUserFeedsCount(): int
    {
        return $this->sidebarOtherUserFeedsCount;
    }

    public function getSidebarTweetsPerUser(): int
    {
        return $this->sidebarTweetsPerUser;
    }
}
