<?php

declare(strict_types=1);

namespace App\Application\Db;

use InvalidArgumentException;
use PDO;

abstract class AbstractStorage
{
    protected PDO $pdo;
    protected const DEFAULT_QUERY_LIMIT = 20;

    public function __construct(DbConnectionPool $dbConnectionPool)
    {
        $this->pdo = $dbConnectionPool->getMainPdo();
    }

    protected function select(array $where = [], array $fields = []): array
    {
        if (empty($fields)) {
            $fieldsString = '*';
        } else {
            $fieldsString = implode(', ', $fields);
        }

        $whereString = '1';
        foreach ($where as $whereCondition) {
            $whereString .= "AND ($whereCondition)";
        }

        $query = "SELECT $fieldsString FROM {$this->getTableName()} WHERE $whereString";

        $statement = $this->pdo->query($query);
        return $statement->fetchAll();
    }

    abstract protected function getTableName();

    protected function validatePositiveInt(int $id): void
    {
        if ($id <= 0) {
            throw new InvalidArgumentException("Invalid ID provided: $id");
        }
    }
}
