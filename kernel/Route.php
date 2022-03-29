<?php

namespace Kernel;

use Kernel\Enums\Regex;

class Route
{
    private readonly string $regex;
    public readonly array $params;
    public readonly string $uri;

    public function __construct(
        string $uri,
        public readonly string $controller,
        public readonly string $action
    ) {
        $this->setUri($uri);
        $this->setRegex();
    }

    public function run(Request $request)
    {
        $this->setParams($request->uri);

        return call_user_func_array(
            [
                new $this->controller,
                $this->action
            ],
            $this->params
        );
    }

    public function isMatch(string $uriResquest): bool
    {
        return boolval(preg_match($this->regex, $uriResquest));
    }

    private function setUri(string $uri)
    {
        $this->uri = empty(trim($uri)) ? '/' : $uri;
    }

    private function setParams(string $uriResquest)
    {
        $splitInputUri = explode('/', $uriResquest);
        $params = $this->getParamPositions($this->uri);

        foreach ($params as $key => $param) {
            $paramValues[$param] = $splitInputUri[$key];
        }

        $this->params = $paramValues ?? [];
    }

    private function setRegex()
    {
        if (empty($this->uri)) return null;

        $backslashAdjusted = preg_replace(Regex::BACKSLASH, Regex::BACKSLASH_IN_REGEX, $this->uri);
        $paramsAdjusted = preg_replace(Regex::FORMAT_PARAM, "+" . Regex::LETTERS_NUMBERS . "+", $backslashAdjusted);

        if (substr($paramsAdjusted, 0, 1) === '+') {
            $paramsAdjusted = substr($paramsAdjusted, 1, -1);
        }

        if (substr($paramsAdjusted, -1) === '+') {
            $paramsAdjusted = substr($paramsAdjusted, 0, -1);
        }

        $this->regex = "/^$paramsAdjusted$/";
    }

    private function getParamPositions($uri): array
    {
        $splitUri = explode('/', $uri);

        $paramPositions = preg_grep(Regex::FORMAT_PARAM, $splitUri);

        return array_map(
            fn ($postion) => $this->removeParamLimit($postion),
            $paramPositions
        );
    }

    private function removeParamLimit(string $params): string
    {
        return str_replace([Regex::PARAM_START, Regex::PARAM_END], '', $params);
    }
}
