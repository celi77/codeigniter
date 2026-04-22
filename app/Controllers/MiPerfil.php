<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class MiPerfil extends Controller
{
    public function miperfil()
    {
        // 🔒 Proteger acceso
        if (!session()->get('logueado')) {
            return redirect()->to(base_url('login'));
        }

        $model = new UsuarioModel();

        // Buscar usuario actual por ID guardado en sesión
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
        if (!session()->get('logueado')) {
            return redirect()->to(base_url('login'));
        }

        $model = new UsuarioModel();
        $idUsuario = session()->get('id_usuario');

        $file = $this->request->getFile('foto');
        $fotoNombre = null;

        // 📸 Subida de imagen
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fotoNombre = $file->getRandomName();
            $file->move('uploads/perfil', $fotoNombre);
        }

        // 📌 Datos a actualizar
        $data = [
            'nombre'    => $this->request->getPost('nombre'),
            'usuario'   => $this->request->getPost('usuario'),
            'email'     => $this->request->getPost('email'),
            'telefono'  => $this->request->getPost('telefono') ?? null,
            'ubicacion' => $this->request->getPost('ubicacion') ?? null,
        ];

        // si subió foto
        if ($fotoNombre) {
            $data['foto'] = $fotoNombre;
        }

        // 💾 actualizar usuario
        $model->update($idUsuario, $data);

        // 🔁 actualizar sesión (opcional pero recomendado)
        session()->set([
            'nombre' => $data['nombre'],
            'email'  => $data['email']
        ]);

        return redirect()->back()->with('mensaje', 'Perfil actualizado correctamente');
    }
}