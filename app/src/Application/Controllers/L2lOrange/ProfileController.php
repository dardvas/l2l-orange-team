<?php


namespace App\Application\Controllers\L2lOrange;

use App\Application\Controllers\AbstractController;
use App\Application\Exceptions\UnauthorizedException;
use App\Domain\L2lOrange\Services\FindMentorService;
use App\Domain\L2lOrange\Services\MyGroupsService;
use App\Domain\L2lOrange\Services\MyMentorsService;
use App\Infrastructure\Containers\ControllerUtils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class ProfileController extends AbstractController
{

    private MyGroupsService $myGroupsService;
    private MyMentorsService $myMentorsService;

    public function __construct(
        LoggerInterface $logger,
        ControllerUtils $controllerUtils,
        MyGroupsService $myGroupsService,
        MyMentorsService $mentorsService
    ) {
        parent::__construct($logger, $controllerUtils);
        $this->myGroupsService = $myGroupsService;
        $this->myMentorsService = $mentorsService;
    }


    public function myGroups_get(ServerRequestInterface $request): ResponseInterface
    {
        $currentUser = $this->getCurrentUser();
        $myGroups = $this->myGroupsService->getMyGroups($currentUser->getId());

        return $this->renderTemplate('profile/myGroups.tpl', [
            'logoutActionUrl' => '/auth/logout',
            'myMentorsUrl' => '/profile/myMentors',
            'becomeMentorUrl' => '/becomeMentor',
            'currentUser' => $currentUser->jsonSerialize(),
            'myGroups' => \GuzzleHttp\json_encode($myGroups),
        ]);
    }

    public function myMentors_get(ServerRequestInterface $request): ResponseInterface
    {
        $currentUser = $this->getCurrentUser();
        $myMentors = $this->myMentorsService->getMyMentors($currentUser->getId());

        return $this->renderTemplate('profile/myMentors.tpl', [
            'logoutActionUrl' => '/auth/logout',
            'myGroupsUrl' => '/profile/myGroups',
            'findMentorUrl' => '/findMentor',
            'currentUser' => $currentUser->jsonSerialize(),
            'myMentors' => \GuzzleHttp\json_encode($myMentors),
        ]);
    }
}
