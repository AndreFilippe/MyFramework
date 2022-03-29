<?php

namespace App\Controllers;

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

    public function mult($id, $bar_id)
    {
        dd([$id, $bar_id]);
    }
}
