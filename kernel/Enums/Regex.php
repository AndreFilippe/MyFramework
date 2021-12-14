<?php

namespace Kernel\Enums;

final class Regex
{
    const LETTERS_NUMBERS = "[a-zA-z1-9]";
    const PARAM_START = '{';
    const PARAM_END = '}';
    const FORMAT_PARAM = "/" . self::PARAM_START . "+" . self::LETTERS_NUMBERS . "+" . self::PARAM_END . "/";
    const BACKSLASH = "/\\//";
    const BACKSLASH_IN_REGEX = "\\\/";
}
