<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use App\Infrastructure\Session\SessionManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpUnauthorizedException;

class AuthMiddleware implements Middleware
{
    private SessionManager $sessionManager;

    public function __construct(SessionManager $sessionManager)
    {
        $this->sessionManager = $sessionManager;
    }

    public function process(Request $request, RequestHandler $handler): Response
    {
        $isAuthorized = $this->sessionManager->get(SessionManager::KEY_USER) !== null;
        if (! $isAuthorized) {
            throw new HttpUnauthorizedException($request);
        }

        return $handler->handle($request);
    }
}
