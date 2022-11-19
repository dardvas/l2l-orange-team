<?php


namespace App\Domain\L2lOrange\Storages;

use App\Application\Db\AbstractStorage;

class MentorsToGroupsWriteStorage extends AbstractStorage
{
    public function assignMentorToGroup(int $mentorId, int $groupId): void
    {
        $statement = $this->pdo->prepare(<<<SQL
            INSERT INTO {$this->getTableName()}
                (mentor_id, group_id) VALUE
                (:mentor_id, :group_id)
        SQL);

        $statement->bindParam(':mentor_id', $mentorId);
        $statement->bindParam(':group_id', $groupId);

        $statement->execute();
    }

    protected function getTableName()
    {
        return 'mentors_to_groups';
    }
}
