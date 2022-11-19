<?php

declare(strict_types=1);

namespace App\Infrastructure\Auth;

use App\Domain\User\User;
use App\Infrastructure\Session\SessionManager;

class AuthService
{
    private SessionManager $sessionManager;

    public function __construct(SessionManager $sessionManager)
    {
        $this->sessionManager = $sessionManager;
    }

    public function authUserToSession(User $user): void
    {
        $this->sessionManager->set(SessionManager::KEY_USER, $user);
    }

    public function deleteUserFromSession(): void
    {
        $this->sessionManager->remove(SessionManager::KEY_USER);
    }
}
