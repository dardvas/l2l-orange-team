<?php


namespace App\Application\Controllers\Index;

use App\Application\Controllers\AbstractController;
use App\Application\Exceptions\UnauthorizedException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class IndexController extends AbstractController
{
    public function index_get(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $currentUser = $this->getCurrentUser();
            $isAuthorized = true;
        } catch (UnauthorizedException $e) {
            $currentUser = null;
            $isAuthorized = false;
        }

        return $this->renderTemplate('index.tpl', [
            'logoutActionUrl' => '/auth/logout',
            'loginUrl' => '/auth/login',
            'signupUrl' => '/auth/signup',
            'findMentorUrl' => '/findMentor',
            'becomeMentorUrl' => '/becomeMentor',
            'currentUser' => $isAuthorized ? $currentUser->jsonSerialize() : null,
            'isAuthorized' => $isAuthorized,
        ]);
    }
}
