<?php

namespace App\Controllers;

class TestMail extends BaseController
{
    public function index()
    {
        $email = \Config\Services::email();

        $email->setFrom(
            'emailkamu@gmail.com',
            'Event Organizer'
        );

        $email->setTo(
            'emailtujuan@gmail.com'
        );

        $email->setSubject(
            'Test Email'
        );

        $email->setMessage('
            <h1>Email berhasil dikirim 🚀</h1>
        ');

        if ($email->send()) {

            echo 'Email berhasil dikirim';

        } else {

            print_r(
                $email->printDebugger(['headers'])
            );
        }
    }
}