<?php


namespace App\Domain\L2lOrange\Entities;

class MenteeGroup implements \JsonSerializable
{
    private int $groupId;
    private int $timeslotId;
    private int $categoryId;
    private bool $isOneTime;

    public function __construct(
        int $groupId,
        int $timeslotId,
        int $categoryId,
        bool $isOneTime
    )
    {
        $this->groupId = $groupId;
        $this->timeslotId = $timeslotId;
        $this->categoryId = $categoryId;
        $this->isOneTime = $isOneTime;
    }

    public function getGroupId(): int
    {
        return $this->groupId;
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

    public function jsonSerialize(): array
    {
        return [
            'groupId' => $this->groupId,
            'timeslotId' => $this->timeslotId,
            'categoryId' => $this->categoryId,
            'isOneTime' => $this->isOneTime,
        ];
    }
}
