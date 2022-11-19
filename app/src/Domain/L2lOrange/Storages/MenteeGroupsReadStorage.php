<?php


namespace App\Domain\L2lOrange\Storages;

use App\Application\Db\AbstractStorage;
use App\Domain\L2lOrange\Dto\CreateMenteeDto;
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


}
