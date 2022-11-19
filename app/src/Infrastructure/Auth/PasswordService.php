<?php

declare(strict_types=1);

namespace App\Infrastructure\Auth;

class PasswordService
{
    // TODO: move to config
    private const PASSWORD_SALT = 'SomeVeryStrongSalt19489efiokfek';

    public function getPasswordHash(string $passwordRaw): string
    {
        return md5($passwordRaw . self::PASSWORD_SALT);
    }
}
