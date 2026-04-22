<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class Registro extends Controller
{
    public function store()
    {
        $model = new UsuarioModel();

        $nombre = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $confirm = $this->request->getPost('confirm_password');

        // 1. Validar contraseñas iguales
        if ($password !== $confirm) {
            return redirect()->back()->with('error', 'Las contraseñas no coinciden');
        }

        // 2. Validar email duplicado
        $existe = $model->where('email', $email)->first();
        if ($existe) {
            return redirect()->back()->with('error', 'El email ya está registrado');
        }

        // 3. Guardar usuario seguro
        $data = [
            'nombre' => $nombre,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'rol' => 'usuario'
        ];

        $model->insert($data);

        return redirect()->to(base_url('login'))->with('success', 'Registro exitoso');
    }
}