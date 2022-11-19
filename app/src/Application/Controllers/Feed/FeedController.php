<?php

declare(strict_types=1);

namespace App\Application\Controllers\Feed;

use App\Application\Controllers\AbstractController;
use App\Application\Exceptions\BadRequestException;
use App\Domain\Feed\FeedConfig;
use App\Domain\Social\OtherUserFeed;
use App\Domain\Social\Services\RecommendationsService;
use App\Domain\Subscription\Services\SubscriptionService;
use App\Domain\Tweet\Services\TweetService;
use App\Domain\Tweet\Storages\TweetReadStorage;
use App\Domain\Tweet\Tweet;
use App\Domain\User\Storages\UserReadStorage;
use App\Infrastructure\Containers\ControllerUtils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class FeedController extends AbstractController
{
    private UserReadStorage $userReadStorage;
    private RecommendationsService $recommendationsService;
    private SubscriptionService $subscriptionService;
    private TweetService $tweetService;

    public function __construct(
        LoggerInterface $logger,
        ControllerUtils $controllerUtils,
        UserReadStorage $userReadStorage,
        RecommendationsService $recommendationsService,
        SubscriptionService $subscriptionService,
        TweetService $tweetService
    ) {
        parent::__construct($logger, $controllerUtils);
        $this->userReadStorage = $userReadStorage;
        $this->recommendationsService = $recommendationsService;
        $this->subscriptionService = $subscriptionService;
        $this->tweetService = $tweetService;
    }

    public function feed_get(ServerRequestInterface $request): ResponseInterface
    {
        $currentUser = $this->getCurrentUser();
        $currentUserId = $currentUser->getId();

        $tweetsSerialized = $this->tweetService->getTweetsSerializedForFeed($currentUserId);

        $otherUsersFeeds = $this->recommendationsService->getOtherUsersFeeds($currentUserId, $currentUserId);
        $otherUsersFeedsAsArray = array_map(static fn(OtherUserFeed $feed) => $feed->jsonSerialize(), $otherUsersFeeds);

        return $this->renderTemplate('feed/index.tpl', [
            'logoutActionUrl' => '/auth/logout',
            'tweetSubmitActionUrl' => '/tweet',
            'subscribeActionUrl' => '/subscribe',
            'currentUser' => $currentUser->jsonSerialize(),
            'tweets' => $tweetsSerialized,
            'otherUsersFeeds' => $otherUsersFeedsAsArray,
            'isMyFeed' => true,
            'isSubscribed' => false,
        ]);
    }

    public function feedByUserId_get(ServerRequestInterface $request, int $feedOwnerId): ResponseInterface
    {
        if ($feedOwnerId <= 0) {
            throw BadRequestException::forInvalidParamValue('userId', $feedOwnerId);
        }

        $currentUser = $this->getCurrentUser();
        $feedOwner = $this->userReadStorage->getUserById($feedOwnerId);

        $tweetsSerialized = $this->tweetService->getTweetsSerializedForFeed($feedOwnerId);

        $otherUsersFeeds = $this->recommendationsService->getOtherUsersFeeds($currentUser->getId(), $feedOwnerId);
        $otherUsersFeedsAsArray = array_map(static fn(OtherUserFeed $feed) => $feed->jsonSerialize(), $otherUsersFeeds);

        $isSubscribed = $this->subscriptionService->isSubscribed($currentUser->getId(), $feedOwnerId);

        return $this->renderTemplate('feed/index.tpl', [
            'logoutActionUrl' => '/auth/logout',
            'tweetSubmitActionUrl' => '/tweet',
            'subscribeActionUrl' => '/subscribe',
            'currentUser' => $currentUser->jsonSerialize(),
            'feedOwner' => $feedOwner->jsonSerialize(),
            'tweets' => $tweetsSerialized,
            'otherUsersFeeds' => $otherUsersFeedsAsArray,
            'isMyFeed' => false,
            'isSubscribed' => $isSubscribed,
        ]);
    }
}
