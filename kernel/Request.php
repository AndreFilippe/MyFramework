<?php

namespace Kernel;

class Request
{
    public readonly string $method;
    public readonly string $uri;
    public readonly object $query;
    public readonly object $formData;
    public readonly object $json;

    public function build()
    {
        $this->setUri();
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->setQuery();
        $this->setFormData();
        $this->setJson();

        return $this;
    }

    private function setUri()
    {
        $this->uri = $this->normalizeUri($_SERVER['REQUEST_URI']);
    }

    private function normalizeUri(string $uriFull): string
    {
        $uri = explode('?', $uriFull)[0];

        $limit = substr($uri, -1) === '/' ? -1 : null;
        $uri = substr($uri, 1, $limit);

        return empty($uri) ? '/' : $uri;
    }

    private function setQuery()
    {
        $this->query = (object) $_GET;
    }

    private function setFormData()
    {
        $this->formData = (object) $_POST;
    }

    private function setJson()
    {
        $this->json = json_decode(file_get_contents('php://input'));
    }
}
