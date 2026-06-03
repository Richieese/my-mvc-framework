<?php

declare(strict_types=1);

namespace Core\View;

class Engine
{
    public function __construct(private readonly string $viewsPath = '') {}

    public function render(string $view, array $data = []): string
    {
        $file = $this->viewsPath . '/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($file)) {
            throw new \RuntimeException("View not found: {$file}");
        }

        $data['baseUrl'] = BASE_URL;
        extract($data, EXTR_SKIP);
        ob_start();
        include $file;
        return (string) ob_get_clean();
    }
}
