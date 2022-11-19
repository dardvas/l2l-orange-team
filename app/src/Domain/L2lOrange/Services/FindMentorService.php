<?php


namespace App\Domain\L2lOrange\Services;

use App\Domain\L2lOrange\Dto\CreateMenteeDto;
use App\Domain\L2lOrange\Storages\MenteeGroupsMembersWriteStorage;
use App\Domain\L2lOrange\Storages\MenteeGroupsReadStorage;
use App\Domain\L2lOrange\Storages\MenteeGroupsWriteStorage;

class FindMentorService
{
    private MenteeGroupsReadStorage $menteeGroupsReadStorage;
    private MenteeGroupsWriteStorage $menteeGroupsWriteStorage;
    private MenteeGroupsMembersWriteStorage $menteeGroupsMembersWriteStorage;

    public function __construct(
        MenteeGroupsReadStorage $menteeGroupsReadStorage,
        MenteeGroupsWriteStorage $menteeGroupsWriteStorage,
        MenteeGroupsMembersWriteStorage $menteeGroupsMembersWriteStorage
    ) {
        $this->menteeGroupsReadStorage = $menteeGroupsReadStorage;
        $this->menteeGroupsWriteStorage = $menteeGroupsWriteStorage;
        $this->menteeGroupsMembersWriteStorage = $menteeGroupsMembersWriteStorage;
    }

    public function createMenteeGroupOrAddToExisting(CreateMenteeDto $createMenteeDto): void
    {
        $groupId = $this->menteeGroupsReadStorage->findExistingGroup($createMenteeDto);

        // TODO: check if group is already full. What is "full"?

        if ($groupId === null) {
            $groupId = $this->menteeGroupsWriteStorage->createNewGroup($createMenteeDto);
        }

        $this->menteeGroupsMembersWriteStorage->addUserToGroup($createMenteeDto->getUserId(), $groupId);
    }
}
