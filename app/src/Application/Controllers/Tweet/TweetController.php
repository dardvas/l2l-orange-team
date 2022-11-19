<?php

declare(strict_types=1);

namespace App\Application\Controllers\Tweet;

use App\Application\Controllers\AbstractController;
use App\Domain\Tweet\Services\TweetService;
use App\Infrastructure\Containers\ControllerUtils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class TweetController extends AbstractController
{
    private TweetService $tweetService;

    public function __construct(
        LoggerInterface $logger,
        ControllerUtils $controllerUtils,
        TweetService $tweetService
    ) {
        parent::__construct($logger, $controllerUtils);
        $this->tweetService = $tweetService;
    }

    public function tweet_post(ServerRequestInterface $request): ResponseInterface
    {
        $requestParams = $request->getParsedBody();
        $this->validateRequired($requestParams, ['user_id', 'message']);

        $userId = (int) $requestParams['user_id'];
        $message = $requestParams['message'];

        $this->tweetService->createNewTweet($userId, $message);

        return $this->redirect('/feed');
    }
}
