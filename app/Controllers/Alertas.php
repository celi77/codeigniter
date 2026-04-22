<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Alertas extends Controller
{
    public function index()
    {
        $data = [
            'cocina' => 35,
            'garaje' => 78,
            'dormitorio' => 120
        ];

        return view('alertas', $data);
    }
}