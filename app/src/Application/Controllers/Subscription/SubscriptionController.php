<?php

declare(strict_types=1);

namespace App\Application\Controllers\Subscription;

use App\Application\Controllers\AbstractController;
use App\Domain\Subscription\Services\SubscriptionService;
use App\Infrastructure\Containers\ControllerUtils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class SubscriptionController extends AbstractController
{
    private SubscriptionService $subscriptionService;

    public function __construct(
        LoggerInterface $logger,
        ControllerUtils $controllerUtils,
        SubscriptionService $subscriptionService
    ) {
        parent::__construct($logger, $controllerUtils);
        $this->subscriptionService = $subscriptionService;
    }

    public function subscribe_post(ServerRequestInterface $request): ResponseInterface
    {
        $requestParams = $request->getParsedBody();
        $this->validateRequired($requestParams, ['publisher_id', 'subscriber_id']);

        $publisherId = (int) $requestParams['publisher_id'];
        $subscriberId = (int) $requestParams['subscriber_id'];

        $this->subscriptionService->subscribe($publisherId, $subscriberId);

        return $this->redirect('/feed/' . $publisherId);
    }
}
