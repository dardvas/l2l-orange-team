<?php


namespace App\Application\Controllers\L2lOrange;

use App\Application\Controllers\AbstractController;
use App\Domain\L2lOrange\Dicts\CategoriesDict;
use App\Domain\L2lOrange\Dicts\TimeslotsDict;
use App\Domain\L2lOrange\Dto\CreateMentorDto;
use App\Domain\L2lOrange\Services\BecomeMentorService;
use App\Infrastructure\Containers\ControllerUtils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class BecomeMentorController extends AbstractController
{
    private BecomeMentorService $becomeMentorService;

    public function __construct(
        LoggerInterface $logger,
        ControllerUtils $controllerUtils,
        BecomeMentorService $becomeMentorService
    ) {
        parent::__construct($logger, $controllerUtils);
        $this->becomeMentorService = $becomeMentorService;
    }

    public function becomeMentor_get(ServerRequestInterface $request): ResponseInterface
    {
        $currentUser = $this->getCurrentUser();

        return $this->renderTemplate('becomeMentor/index.tpl', [
            'logoutActionUrl' => '/auth/logout',
            'formSubmitActionUrl' => '/becomeMentor',
            'findMentorUrl' => '/findMentor',
            'becomeMentorUrl' => '/becomeMentor',
            'profileUrl' => '/profile/myGroups',
            'currentUser' => $currentUser->jsonSerialize(),
            'timeslots' => TimeslotsDict::VALUES,
            'categories' => CategoriesDict::VALUES,
        ]);
    }

    public function becomeMentor_post(ServerRequestInterface $request): ResponseInterface
    {
        $currentUser = $this->getCurrentUser();
        $currentUserId = $currentUser->getId();

        $requestParams = $request->getParsedBody();
        $this->validateRequired($requestParams, ['timeslot_id', 'request', 'category_id']);

        $this->becomeMentorService->createNewMentor(new CreateMentorDto(
            $currentUserId,
            (int) $requestParams['timeslot_id'],
            isset($requestParams['is_one_time']),
            $requestParams['request'],
            (int) $requestParams['category_id'],
        ));

        return $this->renderTemplate('becomeMentor/success.tpl', [
            'logoutActionUrl' => '/auth/logout',
            'currentUser' => $currentUser->jsonSerialize(),
        ]);
    }
}
