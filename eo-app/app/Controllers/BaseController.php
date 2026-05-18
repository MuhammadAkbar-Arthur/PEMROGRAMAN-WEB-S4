<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class BaseController extends Controller
{
    protected function checkLogin()
    {
        if (!session()->get('id')) {
            return redirect()->to('/login')->send();
            exit;
        }
    }
}