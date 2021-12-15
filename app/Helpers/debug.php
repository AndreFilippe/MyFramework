<?php

if (!function_exists('dd')) {
    function dd()
    {
        echo "<pre>";
        var_dump(func_get_args());
        echo "</pre>";

        die;
    }
}
