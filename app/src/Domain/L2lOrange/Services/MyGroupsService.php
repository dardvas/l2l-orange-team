<?php


namespace App\Domain\L2lOrange\Services;

use App\Domain\L2lOrange\Storages\MenteeGroupsReadStorage;
use App\Domain\L2lOrange\Storages\MentorsReadStorage;
use App\Domain\L2lOrange\Storages\MentorsToGroupsReadStorage;

class MyGroupsService
{
    private MentorsReadStorage $mentorsReadStorage;
    private MentorsToGroupsReadStorage $mentorsToGroupsReadStorage;
    private MenteeGroupsReadStorage $menteeGroupsReadStorage;

    public function __construct(
        MentorsReadStorage $mentorsReadStorage,
        MentorsToGroupsReadStorage $mentorsToGroupsReadStorage,
        MenteeGroupsReadStorage $menteeGroupsReadStorage
    )
    {
        $this->mentorsReadStorage = $mentorsReadStorage;
        $this->mentorsToGroupsReadStorage = $mentorsToGroupsReadStorage;
        $this->menteeGroupsReadStorage = $menteeGroupsReadStorage;
    }

    public function getMyGroups(int $userId): array
    {
        // get all my mentor roles
        $myMentorRoles = $this->mentorsReadStorage->getMyMentorRoles($userId);

        $mentorIds = [];
        foreach ($myMentorRoles as $myMentorRole) {
            $mentorIds[] = $myMentorRole->getMentorId();
        }

        $groupsIds = $this->mentorsToGroupsReadStorage->getGroupsIdsByMentorIds($mentorIds);
        $groups = $this->menteeGroupsReadStorage->getGroupsByIds($groupsIds);

        return $groups;
    }
}
