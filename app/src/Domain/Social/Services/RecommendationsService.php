<?php

declare(strict_types=1);

namespace App\Domain\Social\Services;

use App\Domain\Social\OtherUserFeed;
use App\Domain\Social\RecommendationsConfig;
use App\Domain\Tweet\Storages\TweetReadStorage;
use App\Domain\User\Storages\UserReadStorage;
use App\Domain\User\User;

class RecommendationsService
{
    private UserReadStorage $userReadStorage;
    private TweetReadStorage $tweetReadStorage;
    private RecommendationsConfig $recommendationsConfig;

    public function __construct(
        UserReadStorage $userReadStorage,
        TweetReadStorage $tweetReadStorage,
        RecommendationsConfig $recommendationsConfig
    ) {
        $this->userReadStorage = $userReadStorage;
        $this->tweetReadStorage = $tweetReadStorage;
        $this->recommendationsConfig = $recommendationsConfig;
    }

    /**
     * @param int $currentUserId
     * @param int $feedOwnerId
     * @return OtherUserFeed[]
     */
    public function getOtherUsersFeeds(int $currentUserId, int $feedOwnerId): array
    {
        $feedsCount = $this->recommendationsConfig->getSidebarOtherUserFeedsCount();

        // Because we expect sidebar with other user feeds to be displayed on a lot of pages,
        // here we may try to find OtherUserFeed[] in cache by composite key
        // $feedsCount.$currentUserId.$feedOwnerId

        $randomUsersWithTweetsIds = $this->tweetReadStorage
            ->getRandomUsersWithTweetsIdsExcludeGiven([$currentUserId, $feedOwnerId], $feedsCount);

        $randomUsers = $this->userReadStorage->getUsersByIdsExcludeGiven($randomUsersWithTweetsIds);
        $randomUsersById = array_combine(
            array_map(static fn(User $user) => $user->getId(), $randomUsers),
            $randomUsers
        );

        $tweetsPerUser = $this->recommendationsConfig->getSidebarTweetsPerUser();
        $lastUsersTweets = $this->tweetReadStorage->getLastUserTweets($randomUsersWithTweetsIds, $tweetsPerUser);

        $otherUsersFeeds = [];
        foreach ($lastUsersTweets as $tweet) {
            $user = $randomUsersById[$tweet->getUserId()];

            $otherUsersFeeds[] = new OtherUserFeed(
                $user->getUsername(),
                '/feed/' . $user->getId(),
                $tweet->getMessage()
            );
        }

        // And here we can store the returned array in cache by key $feedsCount.$currentUserId.$feedOwnerId

        return $otherUsersFeeds;
    }
}
