<?php

declare(strict_types=1);

namespace App\Infrastructure\Containers;

use App\Infrastructure\Http\Response\ResponseFactory;
use App\Infrastructure\Session\SessionManager;
use App\Infrastructure\View\TemplateManager;

class ControllerUtils
{
    private ResponseFactory $responseFactory;
    private TemplateManager $templateManager;
    private SessionManager $sessionManager;

    public function __construct(
        ResponseFactory $responseFactory,
        TemplateManager $templateManager,
        SessionManager $sessionManager
    ) {
        $this->responseFactory = $responseFactory;
        $this->templateManager = $templateManager;
        $this->sessionManager = $sessionManager;
    }

    public function getResponseFactory(): ResponseFactory
    {
        return $this->responseFactory;
    }

    public function getTemplateManager(): TemplateManager
    {
        return $this->templateManager;
    }

    public function getSessionManager(): SessionManager
    {
        return $this->sessionManager;
    }
}
