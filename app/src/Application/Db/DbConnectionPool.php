<?php

declare(strict_types=1);

namespace App\Application\Db;

use PDO;

class DbConnectionPool
{
    private PDO $pdo;

    public function __construct(
        string $host,
        string $port,
        string $dbname,
        string $username,
        string $password
    )
    {
        $this->pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    }

    public static function fromConfig(array $config): self
    {
        return new self(
            $config['host'],
            $config['port'],
            $config['dbname'],
            $config['username'],
            $config['password'],
        );
    }

    public function getMainPdo(): PDO
    {
        return $this->pdo;
    }
}
