<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Application\Exceptions\BadRequestException;
use App\Application\Exceptions\UnauthorizedException;
use App\Domain\User\User;
use App\Infrastructure\Containers\ControllerUtils;
use App\Infrastructure\Http\Response\ResponseCodesDict;
use App\Infrastructure\Http\Response\ResponseFactory;
use App\Infrastructure\Session\SessionManager;
use App\Infrastructure\View\TemplateManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class AbstractController
{
    private LoggerInterface $logger;
    private ResponseFactory $responseFactory;
    private TemplateManager $templateManager;
    private SessionManager $sessionManager;

    public function __construct(
        LoggerInterface $logger,
        ControllerUtils $controllerUtils
    ) {
        $this->logger = $logger;
        $this->responseFactory = $controllerUtils->getResponseFactory();
        $this->templateManager = $controllerUtils->getTemplateManager();
        $this->sessionManager = $controllerUtils->getSessionManager();
    }

    final protected function getResponseFactory(): ResponseFactory
    {
        return $this->responseFactory;
    }

    final protected function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    final protected function getSessionManager(): SessionManager
    {
        return $this->sessionManager;
    }

    final protected function findCurrentUser(): ?User
    {
        return $this->sessionManager->get(SessionManager::KEY_USER);
    }

    final protected function getCurrentUser(): User
    {
        $user = $this->findCurrentUser();
        if ($user === null) {
            throw new UnauthorizedException("User not found in session");
        }

        return $user;
    }

    protected function redirect($uri, $status = ResponseCodesDict::HTTP_FOUND, array $headers = []): ResponseInterface
    {
        return $this->getResponseFactory()->redirect($uri, $status, $headers);
    }

    protected function html($body, $status = ResponseCodesDict::HTTP_OK, array $headers = []): ResponseInterface
    {
        return $this->getResponseFactory()->html($body, $status, $headers);
    }

    protected function json($data, $meta = [], $status = ResponseCodesDict::HTTP_OK, $headers = []): ResponseInterface
    {
        return $this->getResponseFactory()->json($data, $meta, $status, $headers);
    }

    protected function jsonData(array $data, int $status = ResponseCodesDict::HTTP_OK, array $headers = []): ResponseInterface
    {
        return $this->getResponseFactory()->jsonData($data, $status, $headers);
    }

    protected function jsonHtml(string $content, $meta = [], $status = ResponseCodesDict::HTTP_OK, $headers = []): ResponseInterface
    {
        return $this->getResponseFactory()->json(['content' => $content], $meta, $status, $headers);
    }

    protected function jsonError(array $meta = [], int $status = ResponseCodesDict::HTTP_BAD_REQUEST, array $headers = []): ResponseInterface
    {
        return $this->getResponseFactory()->jsonError(null, $meta, $status, $headers);
    }

    protected function renderTemplate(string $templatePath, array $params): ResponseInterface
    {
        return $this->html($this->templateManager->renderView($templatePath, $params));
    }

    protected function validateRequired(array $requestParams, array $requiredParams): void
    {
        foreach ($requiredParams as $paramName) {
            if (empty($requestParams[$paramName])) {
                throw BadRequestException::forMissingRequiredParam($paramName);
            }
        }
    }
}
