<?php


namespace App\Domain\L2lOrange\Entities;

class MentorRole implements \JsonSerializable
{
    private int $mentorId;
    private int $userId;
    private int $timeslotId;
    private int $categoryId;
    private bool $isOneTime;

    public function __construct(
        int $mentorId,
        int $userId,
        int $timeslotId,
        int $categoryId,
        bool $isOneTime
    )
    {
        $this->mentorId = $mentorId;
        $this->userId = $userId;
        $this->timeslotId = $timeslotId;
        $this->categoryId = $categoryId;
        $this->isOneTime = $isOneTime;
    }

    public function getMentorId(): int
    {
        return $this->mentorId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTimeslotId(): int
    {
        return $this->timeslotId;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function isOneTime(): bool
    {
        return $this->isOneTime;
    }

    public function jsonSerialize()
    {
        return [
            'mentor_id' => $this->mentorId,
            'userId' => $this->userId,
            'timeslotId' => $this->timeslotId,
            'isOneTime' => $this->isOneTime,
            'categoryId' => $this->categoryId,
        ];
    }
}
