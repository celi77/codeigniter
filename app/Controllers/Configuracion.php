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
}