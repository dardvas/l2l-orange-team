<?php

declare(strict_types=1);

namespace App\Infrastructure\View;

use Smarty;

class TemplateManager
{
    private Smarty $smarty;

    public function __construct(Smarty $smarty)
    {
        $this->smarty = $smarty;

        $this->smarty->setTemplateDir(self::TEMPLATE_DIR);
    }

    const TEMPLATE_DIR = '../src/Application/Templates';

    public function renderView(string $templateName, array $templateParams): string
    {
        foreach ($templateParams as $key => $value) {
            $this->smarty->assign($key, $value);
        }

        $template = $this->smarty->fetch($templateName);
        if ($template === false) {
            throw new \RuntimeException('Smarty has failed to render template ' . $templateName);
        }

        return $template;
    }
}
