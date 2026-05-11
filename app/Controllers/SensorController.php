<?php

namespace App\Controllers;

use App\Models\SensorModel;

class SensorController extends BaseController
{
    public function ver($id)
    {
        $model = new SensorModel();

        $sensor = $model->find($id);

        return view('sensor_detalle', [
            'sensor' => $sensor
        ]);
    }

    public function editar($id)
    {
        $model = new SensorModel();

        $model->update($id, [
            'sector' => $this->request->getPost('sector'),
            'funcionamiento' => $this->request->getPost('funcionamiento'),
            'valor_ppm' => $this->request->getPost('valor_ppm')
        ]);

        return redirect()->to(base_url('sensor/' . $id));
    }

    public function apagar($id)
    {
        $model = new SensorModel();

        $model->update($id, [
            'funcionamiento' => 'apagado'
        ]);

        return redirect()->to(base_url('sensor/' . $id));
    }

    public function activar($id)
    {
        $model = new SensorModel();

        $model->update($id, [
            'funcionamiento' => 'activado'
        ]);

        return redirect()->to(base_url('sensor/' . $id));
    }

    public function calibrar($id)
    {
        $model = new SensorModel();

        $model->update($id, [
            'offset_ppm' => $this->request->getPost('offset'),
            'notas_calibracion' => $this->request->getPost('notas')
        ]);

        return redirect()->to(base_url('sensor/' . $id));
    }

    public function eliminar($id)
    {
        $model = new SensorModel();

        $model->delete($id);

        return redirect()->to(base_url('vistaprincipal'));
    }
}