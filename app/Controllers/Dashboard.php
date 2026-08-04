<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'eCommerce Dashboard | TailAdmin - CodeIgniter 4',
        ];

        return view('dashboard/index', $data);
    }
}
