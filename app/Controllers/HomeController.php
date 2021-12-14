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

    public function mult($oder_id, $package_id)
    {
        dd([$oder_id, $package_id]);
    }
}
