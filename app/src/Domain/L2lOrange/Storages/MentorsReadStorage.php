<?php


namespace App\Domain\L2lOrange\Storages;

use App\Application\Db\AbstractStorage;
use App\Domain\L2lOrange\Entities\MentorRole;
use PDO;

class MentorsReadStorage extends AbstractStorage
{
    protected function getTableName()
    {
        return 'mentors';
    }

    /**
     * @param int $userId
     * @return MentorRole[]
     */
    public function getMyMentorRoles(int $userId): array
    {
        $st = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE 
                        user_id=:user_id");
        $st->bindParam(':user_id', $userId);
        $st->execute();

        $rows = $st->fetchAll(PDO::FETCH_ASSOC);
        $roles = [];
        foreach ($rows as $row) {
            $roles[] = new MentorRole(
                (int) $row['id'],
                (int) $row['user_id'],
                (int) $row['timeslot_id'],
                (int) $row['category_id'],
                (bool) $row['is_one_time'],
            );
        }

        return $roles;
    }

    /**
     * @param array $mentorsIds
     * @return MentorRole[]
     */
    public function getMentorRolesByIds(array $mentorsIds): array
    {
        if (empty($mentorsIds)) {
            return [];
        }

        $st = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE 
                        id IN (:mentor_ids)");

        $mentorsIdsStr = implode(',', $mentorsIds);
        $st->bindParam(':mentor_ids', $mentorsIdsStr);
        $st->execute();

        $rows = $st->fetchAll(PDO::FETCH_ASSOC);
        $roles = [];
        foreach ($rows as $row) {
            $roles[] = new MentorRole(
                (int) $row['id'],
                (int) $row['user_id'],
                (int) $row['timeslot_id'],
                (int) $row['category_id'],
                (bool) $row['is_one_time'],
            );
        }

        return $roles;
    }

    /**
     * @param array $excludeIds
     * @return MentorRole[]
     */
    public function getAllMentorsExcept(array $excludeIds): array
    {
        $st = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE 
                        id NOT IN (:exclude_ids)");

        $excludeIdsStr = empty($excludeIds) ? '' : implode(',', $excludeIds);
        $st->bindParam(':exclude_ids', $excludeIdsStr);
        $st->execute();

        $rows = $st->fetchAll(PDO::FETCH_ASSOC);
        $roles = [];
        foreach ($rows as $row) {
            $roles[] = new MentorRole(
                (int) $row['id'],
                (int) $row['user_id'],
                (int) $row['timeslot_id'],
                (int) $row['category_id'],
                (bool) $row['is_one_time'],
            );
        }

        return $roles;
    }
}
