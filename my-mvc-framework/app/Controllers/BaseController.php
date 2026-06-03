<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Http\Response;
use Core\View\Engine;

abstract class BaseController
{
    public function __construct(protected readonly Engine $view) {}

    protected function render(string $template, array $data = []): Response
    {
        return (new Response())->setBody($this->view->render($template, $data));
    }

    protected function redirect(string $url): Response
    {
        return (new Response())->redirect($url);
    }
}
