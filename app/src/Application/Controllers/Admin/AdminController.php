<?php

declare(strict_types=1);

namespace App\Application\Controllers\Admin;

use App\Application\Controllers\AbstractController;
use App\Domain\User\Storages\UserReadStorage;
use App\Infrastructure\Auth\AuthService;
use App\Infrastructure\Containers\ControllerUtils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class AdminController extends AbstractController
{
    private AuthService $authService;
    private UserReadStorage $userReadStorage;

    public function __construct(
        LoggerInterface $logger,
        ControllerUtils $controllerUtils,
        AuthService $authService,
        UserReadStorage $userReadStorage
    ) {
        parent::__construct($logger, $controllerUtils);
        $this->authService = $authService;
        $this->userReadStorage = $userReadStorage;
    }

    public function authAsUser_get(ServerRequestInterface $request): ResponseInterface
    {
        $requestQueryParams = $request->getQueryParams();
        $userId = (int) $requestQueryParams['user_id'];

        $user = $this->userReadStorage->getUserById($userId);

        $this->authService->authUserToSession($user);

        return $this->redirect('/feed');
    }
}
