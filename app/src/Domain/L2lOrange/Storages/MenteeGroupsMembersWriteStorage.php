<?php


namespace App\Domain\L2lOrange\Storages;

use App\Application\Db\AbstractStorage;

class MenteeGroupsMembersWriteStorage extends AbstractStorage
{
    protected function getTableName()
    {
        return 'mentee_groups_members';
    }

    public function addUserToGroup(int $userId, int $groupId): void
    {
        $statement = $this->pdo->prepare(<<<SQL
            INSERT INTO {$this->getTableName()}
                (mentee_group_id, user_id) VALUE
                (:mentee_group_id, :user_id)
        SQL);

        $statement->bindParam(':mentee_group_id', $groupId);
        $statement->bindParam(':user_id', $userId);

        $statement->execute();
    }
}
