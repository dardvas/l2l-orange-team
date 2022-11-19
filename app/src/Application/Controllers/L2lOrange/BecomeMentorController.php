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

    public function becomeMentor_post(ServerRequestInterface $request): ResponseInterface
    {
        $currentUser = $this->getCurrentUser();
        $currentUserId = $currentUser->getId();

        $requestParams = $request->getParsedBody();
        $this->validateRequired($requestParams, ['time_slot_id', 'is_one_time', 'request', 'category_id']);

        $timeSlotId = (int) $requestParams['time_slot_id'];
        $isOneTime = (bool) $requestParams['is_one_time'];
        $mentorshipRequest = $requestParams['request'];
        $categoryId = (int) $requestParams['category_id'];

        // TODO: we can pre-fill some user data in the future
        return $this->renderTemplate('becomeMentor/index.tpl', [
            'logoutActionUrl' => '/auth/logout',
            'formSubmitActionUrl' => '/becomeMentor',
            'currentUserId' => $currentUserId,
        ]);
    }
}
