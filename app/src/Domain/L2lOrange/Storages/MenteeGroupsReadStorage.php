<?php


namespace App\Domain\L2lOrange\Storages;

use App\Application\Db\AbstractStorage;
use App\Domain\L2lOrange\Dto\CreateMenteeDto;
use App\Domain\L2lOrange\Entities\MenteeGroup;
use PDO;

class MenteeGroupsReadStorage extends AbstractStorage
{
    protected function getTableName()
    {
        return 'mentee_groups';
    }

    public function findExistingGroup(CreateMenteeDto $createMenteeDto): ?int
    {
        $categoryId = $createMenteeDto->getCategoryId();
        $timeslotId = $createMenteeDto->getTimeSlotId();
        $isOneTime = $createMenteeDto->isOneTime();

        $st = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE 
                        category_id=:category_id AND timeslot_id=:timeslot_id AND is_one_time=:is_one_time");
        $st->bindParam(':category_id', $categoryId);
        $st->bindParam(':timeslot_id', $timeslotId);
        $st->bindParam(':is_one_time', $isOneTime);
        $st->execute();

        $row = $st->fetch(PDO::FETCH_ASSOC);
        if ($row === false) {
            return null;
        }

        return (int) $row['id'];
    }

    public function getGroupsByIds(array $groupIds): array
    {
        if (empty($groupIds)) {
            return [];
        }

        $st = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE id IN (:group_ids)");
        $groupIdsStr = implode(',', $groupIds);
        $st->bindParam(':group_ids', $groupIdsStr);
        $st->execute();

        $rows = $st->fetchAll(PDO::FETCH_ASSOC);

        $groups = [];
        foreach ($rows as $row) {
            $groups[] = new MenteeGroup(
                (int) $row['id'],
                (int) $row['timeslot_id'],
                (int) $row['category_id'],
                (bool) $row['is_one_time'],
            );
        }

        return $groups;
    }

    /**
     * @param array $excludedIds
     * @return MenteeGroup[]
     */
    public function getAllGroupsExcept(array $excludedIds): array
    {
        $st = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE id NOT IN (:excluded_ids)");
        $excludedIdsStr = empty($excludedIds) ? '' : implode(',', $excludedIds);
        $st->bindParam(':excluded_ids', $excludedIdsStr);
        $st->execute();

        $rows = $st->fetchAll(PDO::FETCH_ASSOC);

        $groups = [];
        foreach ($rows as $row) {
            $groups[] = new MenteeGroup(
                (int) $row['id'],
                (int) $row['timeslot_id'],
                (int) $row['category_id'],
                (bool) $row['is_one_time'],
            );
        }

        return $groups;
    }
}
