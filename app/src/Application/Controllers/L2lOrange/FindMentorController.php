<?php


namespace App\Application\Controllers\L2lOrange;

use App\Application\Controllers\AbstractController;
use App\Domain\L2lOrange\Dicts\CategoriesDict;
use App\Domain\L2lOrange\Dicts\TimeslotsDict;
use App\Domain\L2lOrange\Dto\CreateMenteeDto;
use App\Domain\L2lOrange\Dto\CreateMentorDto;
use App\Domain\L2lOrange\Services\BecomeMentorService;
use App\Domain\L2lOrange\Services\FindMentorService;
use App\Domain\Social\OtherUserFeed;
use App\Infrastructure\Containers\ControllerUtils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class FindMentorController extends AbstractController
{
    private FindMentorService $findMentorService;

    public function __construct(
        LoggerInterface $logger,
        ControllerUtils $controllerUtils,
        FindMentorService $findMentorService
    ) {
        parent::__construct($logger, $controllerUtils);
        $this->findMentorService = $findMentorService;
    }

    public function findMentor_get(ServerRequestInterface $request): ResponseInterface
    {
        $currentUser = $this->getCurrentUser();

        return $this->renderTemplate('findMentor/index.tpl', [
            'logoutActionUrl' => '/auth/logout',
            'formSubmitActionUrl' => '/findMentor',
            'currentUser' => $currentUser->jsonSerialize(),
            'timeslots' => TimeslotsDict::VALUES,
            'categories' => CategoriesDict::VALUES,
        ]);
    }

    public function findMentor_post(ServerRequestInterface $request): ResponseInterface
    {
        $currentUser = $this->getCurrentUser();
        $currentUserId = $currentUser->getId();

        $requestParams = $request->getParsedBody();
        $this->validateRequired($requestParams, ['timeslot_id', 'request', 'category_id']);

        $this->findMentorService->createMenteeGroupOrAddToExisting(new CreateMenteeDto(
            $currentUserId,
            (int) $requestParams['timeslot_id'],
            isset($requestParams['is_one_time']),
            $requestParams['request'],
            (int) $requestParams['category_id'],
        ));

        return $this->renderTemplate('findMentor/success.tpl', [
            'logoutActionUrl' => '/auth/logout',
            'currentUser' => $currentUser->jsonSerialize(),
        ]);
    }
}
