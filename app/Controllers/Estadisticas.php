<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Estadisticas extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Estadísticas',
        ];

        // Carga la vista directamente (temporalmente, sin layout)
        return view('estadisticas', $data);
    }
}