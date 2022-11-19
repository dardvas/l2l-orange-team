<?php

declare(strict_types=1);

namespace App\Application\Controllers\Test;

use App\Application\Controllers\AbstractController;
use App\Domain\User\Storages\UserReadStorage;
use App\Infrastructure\Containers\ControllerUtils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class TestController extends AbstractController
{
    private UserReadStorage $userStorage;

    public function __construct(
        LoggerInterface $logger,
        ControllerUtils $controllerUtils,
        UserReadStorage $userStorage
    ) {
        parent::__construct($logger, $controllerUtils);

        $this->userStorage = $userStorage;
    }

    public function action_test(ServerRequestInterface $request): ResponseInterface
    {
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
