<?php


namespace App\Domain\L2lOrange\Services;

use App\Domain\L2lOrange\Dto\CreateMentorDto;
use App\Domain\L2lOrange\Storages\MentorsWriteStorage;

class BecomeMentorService
{
    private MentorsWriteStorage $mentorsWriteStorage;
    private MatchingService $matchingService;

    public function __construct(
        MentorsWriteStorage $mentorsWriteStorage,
        MatchingService $matchingService
    ) {
        $this->mentorsWriteStorage = $mentorsWriteStorage;
        $this->matchingService = $matchingService;
    }

    public function createNewMentor(CreateMentorDto $createMentorDto): void {
        $this->mentorsWriteStorage->createNewMentor($createMentorDto);
        $this->matchingService->tryAssigningMentors();
    }
}
