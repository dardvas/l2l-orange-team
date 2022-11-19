<?php


namespace App\Domain\L2lOrange\Dto;

use App\Domain\L2lOrange\Dicts\CategoriesDict;
use App\Domain\L2lOrange\Dicts\TimeslotsDict;

class CreateMentorDto
{
    private int $userId;
    private int $timeSlotId;
    private bool $isOneTime;
    private string $mentorshipRequest;
    private int $categoryId;

    public function __construct(
        int $userId,
        int $timeSlotId,
        bool $isOneTime,
        string $mentorshipRequest,
        int $categoryId
    ) {
        CategoriesDict::validate($categoryId);
        TimeslotsDict::validate($timeSlotId);

        $this->userId = $userId;
        $this->timeSlotId = $timeSlotId;
        $this->isOneTime = $isOneTime;
        $this->mentorshipRequest = $mentorshipRequest;
        $this->categoryId = $categoryId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTimeSlotId(): int
    {
        return $this->timeSlotId;
    }

    public function isOneTime(): bool
    {
        return $this->isOneTime;
    }

    public function getMentorshipRequest(): string
    {
        return $this->mentorshipRequest;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }
}
