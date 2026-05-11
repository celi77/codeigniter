<?php

namespace App\Controllers;

use App\Models\SensorModel;
use CodeIgniter\Controller;

class Alertas extends Controller
{
    public function index()
    {
        $sensorModel = new SensorModel();

        $sensores = $sensorModel->findAll();

        return view('alertas', [
            'sensores' => $sensores
        ]);
    }
}