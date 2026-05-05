<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class MiPerfil extends Controller
{
    public function miperfil()
    {
        // 🔒 PROTECCIÓN CORRECTA
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $model = new UsuarioModel();

        $usuario = $model->find(session()->get('id_usuario'));

        $data = [
            'titulo'    => 'Mi Perfil - Monitoreo Inteligente de CO',
            'nombre'    => $usuario['nombre'],
            'usuario'   => $usuario['nombre'],
            'email'     => $usuario['email'],
            'telefono'  => $usuario['telefono'] ?? '',
            'ubicacion' => $usuario['ubicacion'] ?? '',
            'foto'      => $usuario['foto'] ?? null
        ];

        return view('miperfil', $data);
    }

    public function guardar()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $model = new UsuarioModel();
        $idUsuario = session()->get('id_usuario');

        $file = $this->request->getFile('foto');
        $fotoNombre = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fotoNombre = $file->getRandomName();
            $file->move('uploads/perfil', $fotoNombre);
        }

        $data = [
            'nombre'    => $this->request->getPost('nombre'),
            'usuario'   => $this->request->getPost('usuario'),
            'email'     => $this->request->getPost('email'),
            'telefono'  => $this->request->getPost('telefono') ?? null,
            'ubicacion' => $this->request->getPost('ubicacion') ?? null,
        ];

        if ($fotoNombre) {
            $data['foto'] = $fotoNombre;
        }

        $model->update($idUsuario, $data);

        session()->set([
            'nombre' => $data['nombre'],
            'email'  => $data['email']
        ]);

        return redirect()->back()->with('mensaje', 'Perfil actualizado correctamente');
    }
}