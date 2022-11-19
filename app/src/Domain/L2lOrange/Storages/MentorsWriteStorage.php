<?php


namespace App\Domain\L2lOrange\Storages;

use App\Application\Db\AbstractStorage;
use App\Domain\L2lOrange\Dto\CreateMentorDto;

class MentorsWriteStorage extends AbstractStorage
{
    public function createNewMentor(CreateMentorDto $createMentorDto): int {
        $statement = $this->pdo->prepare(<<<SQL
            INSERT INTO {$this->getTableName()}
                (id, user_id, timeslot_id, category_id, is_one_time, mentorship_request) VALUE
                (null, :user_id, :timeslot_id, :category_id, :is_one_time, :mentorship_request)
        SQL);

        $userId = $createMentorDto->getUserId();
        $statement->bindParam(':user_id', $userId);
        $timeSlotId = $createMentorDto->getTimeSlotId();
        $statement->bindParam(':timeslot_id', $timeSlotId);
        $categoryId = $createMentorDto->getCategoryId();
        $statement->bindParam(':category_id', $categoryId);
        $isOneTime = $createMentorDto->isOneTime();
        $statement->bindParam(':is_one_time', $isOneTime);
        $mentorshipRequest = $createMentorDto->getMentorshipRequest();
        $statement->bindParam(':mentorship_request', $mentorshipRequest);

        $statement->execute();

        return (int) $this->pdo->lastInsertId();
    }

    protected function getTableName()
    {
        return 'mentors';
    }
}
