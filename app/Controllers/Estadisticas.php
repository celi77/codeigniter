<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\SensorModel;

class Estadisticas extends Controller
{
    public function index()
    {
        $model = new SensorModel();

        $sensores = $model->findAll();

        $data = [
            'title' => 'Estadísticas',
            'sensores' => $sensores
        ];

        return view('estadisticas', $data);
    }
}