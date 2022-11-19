<?php


namespace App\Domain\L2lOrange\Storages;

use App\Application\Db\AbstractStorage;
use PDO;

class MentorsToGroupsReadStorage extends AbstractStorage
{
    protected function getTableName()
    {
        return 'mentors_to_groups';
    }

    public function getGroupsIdsByMentorIds(array $mentorIds): array
    {
        if (empty($mentorIds)) {
            return [];
        }

        $st = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE mentor_id IN (:mentor_id)");
        $mentorIdsStr = implode(',', $mentorIds);
        $st->bindParam(':mentor_id', $mentorIdsStr);
        $st->execute();

        $rows = $st->fetchAll(PDO::FETCH_ASSOC);

        $groupsIds = [];
        foreach ($rows as $row) {
            $groupsIds[] = (int) $row['group_id'];
        }

        return $groupsIds;
    }

    public function getMentorsByGroupIds(array $groupIds): array
    {
        if (empty($groupIds)) {
            return [];
        }

        $st = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE group_id IN (:group_ids)");
        $groupIdsStr = implode(',', $groupIds);
        $st->bindParam(':group_ids', $groupIdsStr);
        $st->execute();

        $rows = $st->fetchAll(PDO::FETCH_ASSOC);

        $mentorIds = [];
        foreach ($rows as $row) {
            $mentorIds[] = (int) $row['mentor_id'];
        }

        return $mentorIds;
    }
}
