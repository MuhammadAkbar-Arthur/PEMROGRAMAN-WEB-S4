<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class OrganizerFilter implements FilterInterface
{
    public function before(
        RequestInterface $request,
        $arguments = null
    )
    {
        if (
            !session()->get('logged_in')
        ) {

            return redirect()->to('/login');
        }

        if (
            session()->get('role') != 'organizer'
        ) {

            return redirect()->to('/')
                ->with(
                    'error',
                    'Akses organizer ditolak'
                );
        }
    }

    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ) {
    }
}