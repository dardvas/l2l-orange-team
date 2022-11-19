<?php

declare(strict_types=1);

namespace App\Infrastructure\Session;

use Symfony\Component\HttpFoundation\Session\Session;

class SessionManager
{
    public const KEY_USER = 'user';

    private Session $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function __destruct()
    {
        if ($this->session->isStarted()) {
            $this->session->clear();
        }
    }

    public function set(string $key, $value): void
    {
        $this->session->set($key, $value);
    }

    public function get(string $key, $default = null)
    {
        return $this->session->get($key, $default);
    }

    public function clear(): void
    {
        $this->session->clear();
    }

    public function remove(string $key): void
    {
        $this->session->remove($key);
    }
}
