<?php


namespace App\Application\Controllers\L2lOrange;

use App\Application\Controllers\AbstractController;
use App\Domain\Social\OtherUserFeed;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class FindMentorController extends AbstractController
{
    public function findMentor_get(ServerRequestInterface $request): ResponseInterface
    {
        $currentUser = $this->getCurrentUser();
        $currentUserId = $currentUser->getId();

        // TODO: we can pre-fill some user data in the future
        return $this->renderTemplate('findMentor/index.tpl', [
            'logoutActionUrl' => '/auth/logout',
            'formSubmitActionUrl' => '/findMentor',
            'currentUserId' => $currentUserId,
        ]);
    }

    public function findMentor_post(ServerRequestInterface $request): ResponseInterface
    {

    }
}
