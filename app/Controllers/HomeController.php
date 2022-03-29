<?php

namespace App\Controllers;

use Kernel\Request;

class HomeController
{
    public function home()
    {
        dd('home');
    }

    public function index($id)
    {
        dd($id);
    }

    public function mult($id, $bar_id, Request $request)
    {
        dd([$id, $bar_id, $request]);
    }
}
