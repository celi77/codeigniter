<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UsuarioModel;

class Configuracion extends Controller
{
    public function index()
    {
        $model = new UsuarioModel();
        $data['usuarios'] = $model->findAll();

        return view('configuracion', $data);
    }

    public function actualizarRol()
    {
        $model = new UsuarioModel();

        $id = $this->request->getPost('id');
        $rol = $this->request->getPost('rol');

        $model->update($id, ['rol' => $rol]);

        return redirect()->to('/configuracion');
    }
    public function guardarSensor()
{
    $sensorModel = new \App\Models\SensorModel();

    $data = [
        'sector' => $this->request->getPost('sector'),
        'funcionamiento' => $this->request->getPost('funcionamiento')
    ];

    $sensorModel->insert($data);

    return redirect()->to('/configuracion')->with('success', 'Sensor creado correctamente');
}
}