<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class Login extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function checkLogin()
    {
        $session = session();
        $model = new UsuarioModel();

        $email = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Buscar usuario
        $usuario = $model->where('email', $email)->first();

        if (!$usuario) {
            return redirect()->back()->with('error', 'Usuario no encontrado');
        }

        if (!password_verify($password, $usuario['password'])) {
            return redirect()->back()->with('error', 'Contraseña incorrecta');
        }

        // 🔥 ACÁ ESTABA EL ERROR: faltaba rol
        $session->set([
            'id_usuario' => $usuario['id'],
            'nombre' => $usuario['nombre'],
            'email' => $usuario['email'],
            'rol' => $usuario['rol'], // ✔️ ESTO ES CLAVE
            'logueado' => true
        ]);

        return redirect()->to(base_url('vistaprincipal'));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}