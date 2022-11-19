<?php

declare(strict_types=1);

namespace App\Domain\User\Storages;

use App\Application\Db\AbstractStorage;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\User\User;
use PDO;

class UserReadStorage extends AbstractStorage
{
    public function getUsers(): array
    {
        $st = $this->pdo->query("SELECT * FROM users");

        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findUserById(int $id): ?User
    {
        $this->validatePositiveInt($id);

        $st = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE id=:id");
        $st->bindParam(':id', $id);
        $st->execute();

        $userRow = $st->fetch(PDO::FETCH_ASSOC);
        if ($userRow === false) {
            return null;
        }

        return new User(
            (int) $userRow['id'],
            $userRow['username'],
            $userRow['password_hash']
        );
    }

    public function getUserById(int $id): User
    {
        $user = $this->findUserById($id);
        if ($user === null) {
            throw DomainRecordNotFoundException::forClassAndId(self::class, $id);
        }

        return $user;
    }

    public function findUserByUsernameAndPasswordHash(string $username, string $passwordHash): ?User
    {
        $st = $this->pdo->prepare(<<<SQL
            SELECT * FROM {$this->getTableName()} 
            WHERE username=:username
                AND password_hash=:passwordHash
        SQL);
        $st->bindParam(':username', $username);
        $st->bindParam(':passwordHash', $passwordHash);
        $st->execute();

        $userRow = $st->fetch(PDO::FETCH_ASSOC);
        if ($userRow === false) {
            return null;
        }

        return new User(
            (int) $userRow['id'],
            $userRow['username'],
            $userRow['password_hash']
        );
    }

    public function getUserByUsernameAndPasswordHash(string $username, string $passwordHash): User
    {
        $user = $this->findUserByUsernameAndPasswordHash($username, $passwordHash);
        if ($user === null) {
            throw new DomainRecordNotFoundException("User not found");
        }

        return $user;
    }

    /**
     * @param array $userIds
     * @return User[]
     */
    public function getUsersByIdsExcludeGiven(
        array $userIds
    ): array {
        foreach ($userIds as $userId) {
            $this->validatePositiveInt($userId);
        }

        $qMarks = str_repeat('?,', count($userIds) - 1) . '?';

        $st = $this->pdo->prepare(<<<SQL
            SELECT * FROM {$this->getTableName()} 
            WHERE id IN ({$qMarks})
        SQL);

        $st->execute($userIds);

        $userRows = $st->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach($userRows as $userRow) {
            $users[] = new User(
                (int) $userRow['id'],
                $userRow['username'],
                $userRow['password_hash']
            );
        }

        return $users;
    }

    protected function getTableName()
    {
        return 'users';
    }
}
