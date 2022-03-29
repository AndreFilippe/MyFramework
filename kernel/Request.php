<?php

namespace Kernel;

class Request
{
    public readonly string $method;
    public readonly string $uri;

    public function build()
    {
        $this->setUri();
        $this->method = $_SERVER['REQUEST_METHOD'];

        return $this;
    }

    private function setUri()
    {
        $this->uri = $this->normalizeUri($_SERVER['REQUEST_URI']);
    }

    private function normalizeUri(string $url): string
    {
        $limit = substr($url, -1) === '/' ? -1 : null;
        $uri = substr($url, 1, $limit);

        return empty($uri) ? '/' : $uri;
    }
}
