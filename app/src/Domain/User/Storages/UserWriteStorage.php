<?php

declare(strict_types=1);

namespace App\Domain\User\Storages;

use App\Application\Db\AbstractStorage;

class UserWriteStorage extends AbstractStorage
{
    public function insertNewUser(string $username, string $passwordHash): int
    {
        $statement = $this->pdo->prepare(<<<SQL
            INSERT INTO {$this->getTableName()}
                (id, username, password_hash) VALUE
                (null, :username, :password_hash)
        SQL);

        $statement->bindParam(':username', $username);
        $statement->bindParam(':password_hash', $passwordHash);

        $statement->execute();

        return (int) $this->pdo->lastInsertId();
    }

    protected function getTableName()
    {
        return 'users';
    }
}
