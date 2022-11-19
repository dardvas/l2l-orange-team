<?php


namespace App\Domain\L2lOrange\Storages;

use App\Application\Db\AbstractStorage;
use App\Domain\L2lOrange\Dto\CreateMenteeDto;

class MenteeGroupsWriteStorage extends AbstractStorage
{
    protected function getTableName()
    {
        return 'mentee_groups';
    }

    public function createNewGroup(CreateMenteeDto $createMenteeDto): int
    {
        $statement = $this->pdo->prepare(<<<SQL
            INSERT INTO {$this->getTableName()}
                (id, timeslot_id, category_id, is_one_time) VALUE
                (null, :timeslot_id, :category_id, :is_one_time)
        SQL);

        $timeSlotId = $createMenteeDto->getTimeSlotId();
        $statement->bindParam(':timeslot_id', $timeSlotId);
        $categoryId = $createMenteeDto->getCategoryId();
        $statement->bindParam(':category_id', $categoryId);
        $isOneTime = $createMenteeDto->isOneTime();
        $statement->bindParam(':is_one_time', $isOneTime);

        $statement->execute();

        return (int) $this->pdo->lastInsertId();
    }
}
