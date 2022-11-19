<?php


namespace App\Application\Controllers\L2lOrange;

use App\Application\Controllers\AbstractController;
use App\Application\Exceptions\UnauthorizedException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ProfileController extends AbstractController
{
    public function myGroups_get(ServerRequestInterface $request): ResponseInterface
    {
        $currentUser = $this->getCurrentUser();

        return $this->renderTemplate('profile/index.tpl', [
            'logoutActionUrl' => '/auth/logout',
            'myMentorsUrl' => '/profile/myMentors',
            'currentUser' => $currentUser->jsonSerialize(),
        ]);
    }

    public function myMentors_get(ServerRequestInterface $request): ResponseInterface
    {
        $currentUser = $this->getCurrentUser();

        return $this->renderTemplate('profile/index.tpl', [
            'logoutActionUrl' => '/auth/logout',
            'myGroupsUrl' => '/profile/myGroups',
            'currentUser' => $currentUser->jsonSerialize(),
        ]);
    }
}
