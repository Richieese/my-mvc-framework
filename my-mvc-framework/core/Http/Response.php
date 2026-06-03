<?php

declare(strict_types=1);

namespace Core\Http;

class Response
{
    private int    $statusCode = 200;
    private string $body       = '';

    public function setStatusCode(int $code): static
    {
        $this->statusCode = $code;
        return $this;
    }

    public function setBody(string $body): static
    {
        $this->body = $body;
        return $this;
    }

    public function redirect(string $url): never
    {
        $base = BASE_URL !== '/' ? BASE_URL : '';
        header("Location: {$base}{$url}");
        exit;
    }

    public function send(): void
    {
        http_response_code($this->statusCode);
        echo $this->body;
    }
}
