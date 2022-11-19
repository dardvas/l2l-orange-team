<?php


namespace App\Domain\L2lOrange\Services;

use App\Domain\L2lOrange\Dto\CreateMentorDto;
use App\Domain\L2lOrange\Storages\MentorsWriteStorage;

class BecomeMentorService
{
    private MentorsWriteStorage $mentorsWriteStorage;

    public function __construct(
        MentorsWriteStorage $mentorsWriteStorage
    ) {
        $this->mentorsWriteStorage = $mentorsWriteStorage;
    }

    public function createNewMentor(CreateMentorDto $createMentorDto): void {
        $this->mentorsWriteStorage->createNewMentor($createMentorDto);
    }
}
