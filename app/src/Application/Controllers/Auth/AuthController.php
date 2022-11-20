<?php

declare(strict_types=1);

namespace App\Application\Controllers\Auth;

use App\Application\Controllers\AbstractController;
use App\Application\Exceptions\BadRequestException;
use App\Domain\User\Services\LoginService;
use App\Domain\User\Services\SignupService;
use App\Infrastructure\Auth\AuthService;
use App\Infrastructure\Containers\ControllerUtils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class AuthController extends AbstractController
{
    private SignupService $signupService;
    private AuthService $authService;
    private LoginService $loginService;

    public function __construct(
        LoggerInterface $logger,
        ControllerUtils $controllerUtils,
        SignupService $signupService,
        AuthService $authService,
        LoginService $loginService
    ) {
        parent::__construct($logger, $controllerUtils);
        $this->signupService = $signupService;
        $this->authService = $authService;
        $this->loginService = $loginService;
    }

    public function login_get(ServerRequestInterface $request): ResponseInterface
    {
        return $this->renderTemplate('auth/login.tpl', [
            'actionUrl' => '/auth/login',
            'signupUrl' => '/auth/signup',
        ]);
    }

    public function login_post(ServerRequestInterface $request): ResponseInterface
    {
        $requestParams = $request->getParsedBody();
        $this->validateRequired($requestParams, ['username', 'password']);

        $username = $requestParams['username'];
        $password = $requestParams['password'];

        $this->loginService->loginByUsernameAndPassword($username, $password);

        return $this->redirect('/');
    }

    public function logout_post(ServerRequestInterface $request): ResponseInterface
    {
        $this->authService->deleteUserFromSession();

        return $this->redirect('/');
    }

    public function signup_get(ServerRequestInterface $request): ResponseInterface
    {
        return $this->renderTemplate('auth/signup.tpl', [
            'actionUrl' => '/auth/signup',
            'loginUrl' => '/auth/login',
        ]);
    }

    public function signup_post(ServerRequestInterface $request): ResponseInterface
    {
        $requestParams = $request->getParsedBody();
        $this->validateRequired($requestParams, ['username', 'password', 'password_repeat']);

        $password = $requestParams['password'];
        $passwordRepeat = $requestParams['password_repeat'];
        if ($password !== $passwordRepeat) {
            throw new BadRequestException("Passwords doesn't match");
        }

        $username = $requestParams['username'];

        $user = $this->signupService->registerNewUser($username, $password);
        $this->authService->authUserToSession($user);

        return $this->redirect('/');
    }
}
