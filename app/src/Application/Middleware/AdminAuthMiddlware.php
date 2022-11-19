<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpUnauthorizedException;

class AdminAuthMiddlware implements MiddlewareInterface
{
    private const VALID_ADMIN_TOKEN = 'imasupaadmin';

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $requestQueryParams = $request->getQueryParams();
        $adminToken = $requestQueryParams['token'];

        if ($adminToken !== self::VALID_ADMIN_TOKEN) {
            throw new HttpUnauthorizedException($request);
        }

        return $handler->handle($request);
    }
}
