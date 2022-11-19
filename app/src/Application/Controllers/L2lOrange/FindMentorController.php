<?php


namespace App\Application\Controllers\L2lOrange;

use App\Application\Controllers\AbstractController;
use App\Domain\L2lOrange\Dicts\CategoriesDict;
use App\Domain\L2lOrange\Dicts\TimeslotsDict;
use App\Domain\Social\OtherUserFeed;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class FindMentorController extends AbstractController
{
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

    }
}
