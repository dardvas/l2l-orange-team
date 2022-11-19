<?php

declare(strict_types=1);

namespace App\Domain\User\Services;

use App\Domain\User\User;
use App\Domain\User\Storages\UserReadStorage;
use App\Domain\User\Storages\UserWriteStorage;
use App\Infrastructure\Auth\PasswordService;

class SignupService
{
    private UserWriteStorage $userWriteStorage;
    private UserReadStorage $userReadStorage;
    private PasswordService $passwordService;

    public function __construct(
        UserWriteStorage $userWriteStorage,
        UserReadStorage $userReadStorage,
        PasswordService $passwordService
    ) {
        $this->userWriteStorage = $userWriteStorage;
        $this->userReadStorage = $userReadStorage;
        $this->passwordService = $passwordService;
    }

    public function registerNewUser(string $username, string $passwordRaw): User
    {
        $passwordHash = $this->passwordService->getPasswordHash($passwordRaw);
        $newUserId = $this->userWriteStorage->insertNewUser($username, $passwordHash);

        return $this->userReadStorage->getUserById($newUserId);
    }
}
