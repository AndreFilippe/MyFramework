<?php

if (!function_exists('dd')) {
    function dd($data, $isDie = true)
    {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";

        if ($isDie) die;
    }
}
