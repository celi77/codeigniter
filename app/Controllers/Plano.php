<?php

namespace App\Controllers;

use App\Models\SensorModel;

class Plano extends BaseController
{
    public function index()
{
    $model = new SensorModel();

    echo "<pre>";
    print_r($model->findAll());
    echo "</pre>";
}
    // 🔎 Vista particular de un sensor
    public function detalle($id)
    {
        $model = new SensorModel();

        $data['sensor'] = $model->find($id); // trae UNO solo

        if (!$data['sensor']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sensor no encontrado');
        }

        return view('sensor_detalle', $data);
    }
}