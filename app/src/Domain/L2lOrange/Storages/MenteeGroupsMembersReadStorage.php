<?php


namespace App\Domain\L2lOrange\Storages;

use App\Application\Db\AbstractStorage;
use PDO;

class MenteeGroupsMembersReadStorage extends AbstractStorage
{
    protected function getTableName()
    {
        return 'mentee_groups_members';
    }

    public function getMyGroupIds(int $userId): array
    {
        $st = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE 
                        user_id=:user_id");
        $st->bindParam(':user_id', $userId);
        $st->execute();

        $rows = $st->fetchAll(PDO::FETCH_ASSOC);
        $ids = [];
        foreach ($rows as $row) {
            $ids[] = $row['mentee_group_id'];
        }

        return $ids;
    }
}
