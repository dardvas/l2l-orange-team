<?php


namespace App\Application\Controllers\L2lOrange;

use App\Application\Controllers\AbstractController;
use App\Domain\Social\OtherUserFeed;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BecomeMentorController extends AbstractController
{
    public function becomeMentor_get(ServerRequestInterface $request): ResponseInterface
    {
        $currentUser = $this->getCurrentUser();
        $currentUserId = $currentUser->getId();

        // TODO: we can pre-fill some user data in the future
        return $this->renderTemplate('becomeMentor/index.tpl', [
            'logoutActionUrl' => '/auth/logout',
            'formSubmitActionUrl' => '/becomeMentor',
            'currentUserId' => $currentUserId,
        ]);
    }
}
