<?php

declare(strict_types=1);

namespace App\Domain\User\Services;

use App\Domain\User\Storages\UserReadStorage;
use App\Infrastructure\Auth\AuthService;
use App\Infrastructure\Auth\PasswordService;

class LoginService
{
    private UserReadStorage $userReadStorage;
    private PasswordService $passwordService;
    private AuthService $authService;

    public function __construct(
        UserReadStorage $userReadStorage,
        PasswordService $passwordService,
        AuthService $authService
    ) {
        $this->userReadStorage = $userReadStorage;
        $this->passwordService = $passwordService;
        $this->authService = $authService;
    }

    public function loginByUsernameAndPassword(string $username, string $passwordRaw): void
    {
        $passwordHash = $this->passwordService->getPasswordHash($passwordRaw);
        $user = $this->userReadStorage->getUserByUsernameAndPasswordHash($username, $passwordHash);

        $this->authService->authUserToSession($user);
    }
}
