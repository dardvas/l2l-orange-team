<?php

declare(strict_types=1);

namespace App\Application\Controllers\Test;

use App\Application\Controllers\AbstractController;
use App\Domain\L2lOrange\Services\MatchingService;
use App\Domain\User\Storages\UserReadStorage;
use App\Infrastructure\Containers\ControllerUtils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class TestController extends AbstractController
{
    private MatchingService $matchingService;

    public function __construct(
        LoggerInterface $logger,
        ControllerUtils $controllerUtils,
        MatchingService $matchingService
    ) {
        parent::__construct($logger, $controllerUtils);

        $this->matchingService = $matchingService;
    }

    public function action_test(ServerRequestInterface $request): ResponseInterface
    {
        $this->matchingService->tryAssigningMentors();

        return $this->json([]);

        return $this->renderTemplate('test/test.tpl', [
            'a' => 'b',
            'b' => 'c',
            'arr' => [
                'wer' => 'asd',
            ]
        ]);
    }
}
