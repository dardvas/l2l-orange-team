<?php


namespace App\Domain\L2lOrange\Services;

use App\Domain\L2lOrange\Storages\MenteeGroupsMembersReadStorage;
use App\Domain\L2lOrange\Storages\MenteeGroupsReadStorage;
use App\Domain\L2lOrange\Storages\MentorsReadStorage;
use App\Domain\L2lOrange\Storages\MentorsToGroupsReadStorage;

class MyMentorsService
{
    private MenteeGroupsMembersReadStorage $menteeGroupsMembersReadStorage;
    private MentorsReadStorage $mentorsReadStorage;
    private MentorsToGroupsReadStorage $mentorsToGroupsReadStorage;

    public function __construct(
        MentorsReadStorage $mentorsReadStorage,
        MentorsToGroupsReadStorage $mentorsToGroupsReadStorage,
        MenteeGroupsMembersReadStorage $menteeGroupsMembersReadStorage
    )
    {
        $this->mentorsReadStorage = $mentorsReadStorage;
        $this->mentorsToGroupsReadStorage = $mentorsToGroupsReadStorage;
        $this->menteeGroupsMembersReadStorage = $menteeGroupsMembersReadStorage;
    }

    public function getMyMentors(int $userId): array
    {
        $groupIds = $this->menteeGroupsMembersReadStorage->getMyGroupIds($userId);
        $mentorsIds = $this->mentorsToGroupsReadStorage->getMentorsByGroupIds($groupIds);
        return $this->mentorsReadStorage->getMentorRolesByIds($mentorsIds);
    }
}
