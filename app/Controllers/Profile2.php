<?php

namespace App\Controllers;

class Profile2 extends BaseController
{
    public function index(): string
    {
        return view('v_profile');
    }
}
