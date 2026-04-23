<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\SensorModel;

class VistaPrincipal extends Controller
{
    public function index()
    {
        $sensorModel = new SensorModel();

        $data['sensores'] = $sensorModel->findAll();

        return view('vistaprincipal', $data);
    }
}