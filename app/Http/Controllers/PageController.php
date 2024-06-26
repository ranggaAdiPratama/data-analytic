<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        if (!auth()->user()) {
            redirect()->to('/auth/login');
        }

        echo 'a';
    }

    public function login()
    {
        return view('auth');
    }
}
