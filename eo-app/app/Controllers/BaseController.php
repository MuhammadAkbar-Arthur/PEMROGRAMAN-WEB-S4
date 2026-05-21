<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class BaseController extends Controller
{
    protected function checkLogin()
    {
        if (!session()->get('logged_in')) {

            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    'Login terlebih dahulu'
                )
                ->send();

            exit;
        }
    }
}