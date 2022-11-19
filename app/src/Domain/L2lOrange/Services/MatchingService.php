<?php


namespace App\Domain\L2lOrange\Services;

use App\Domain\L2lOrange\Entities\MenteeGroup;
use App\Domain\L2lOrange\Entities\MentorRole;
use App\Domain\L2lOrange\Storages\MenteeGroupsReadStorage;
use App\Domain\L2lOrange\Storages\MentorsReadStorage;
use App\Domain\L2lOrange\Storages\MentorsToGroupsReadStorage;
use App\Domain\L2lOrange\Storages\MentorsToGroupsWriteStorage;

class MatchingService
{
    private MentorsToGroupsReadStorage $mentorsToGroupsReadStorage;
    private MentorsReadStorage $mentorsReadStorage;
    private MenteeGroupsReadStorage $menteeGroupsReadStorage;
    private MentorsToGroupsWriteStorage $mentorsToGroupsWriteStorage;

    public function __construct(
        MentorsToGroupsReadStorage $mentorsToGroupsReadStorage,
        MentorsReadStorage $mentorsReadStorage,
        MenteeGroupsReadStorage $menteeGroupsReadStorage,
        MentorsToGroupsWriteStorage $mentorsToGroupsWriteStorage
    )
    {
        $this->mentorsToGroupsReadStorage = $mentorsToGroupsReadStorage;
        $this->mentorsReadStorage = $mentorsReadStorage;
        $this->menteeGroupsReadStorage = $menteeGroupsReadStorage;
        $this->mentorsToGroupsWriteStorage = $mentorsToGroupsWriteStorage;
    }

    public function tryAssigningMentors(): void
    {
        // get all unassigned mentors
        $assignedMentorsIds = $this->mentorsToGroupsReadStorage->getAllAssignedMentorsIds();
        $unassignedMentors = $this->mentorsReadStorage->getAllMentorsExcept($assignedMentorsIds);

        // get all unassigned groups
        $assignedGroupsIds = $this->mentorsToGroupsReadStorage->getAllAssignedGroupsIds();
        $unassignedGroups = $this->menteeGroupsReadStorage->getAllGroupsExcept($assignedGroupsIds);

        $groupsAssignedDuringThisRun = [];
        $mentorsAssignedDuringThisRun = [];

        foreach ($unassignedMentors as $mentor) {
            if (in_array($mentor->getMentorId(), $mentorsAssignedDuringThisRun, true)) {
                continue;
            }

            foreach ($unassignedGroups as $group) {
                if (in_array($group->getGroupId(), $groupsAssignedDuringThisRun, true)) {
                    continue;
                }

                if ($this->canAssignMentor($mentor, $group)) {
                    $this->mentorsToGroupsWriteStorage->assignMentorToGroup($mentor->getMentorId(), $group->getGroupId());

                    $groupsAssignedDuringThisRun[] = $group->getGroupId();
                    $mentorsAssignedDuringThisRun[] = $mentor->getMentorId();

                    break;
                }
            }
        }
    }

    private function canAssignMentor(MentorRole $mentor, MenteeGroup $group): bool {
        return $mentor->getTimeslotId() === $group->getTimeslotId()
            && $mentor->getCategoryId() === $group->getCategoryId()
            && ($mentor->isOneTime() === $group->isOneTime());
    }
}
