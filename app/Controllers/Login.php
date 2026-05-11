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
        $model = new UsuarioModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $usuario = $model->where('email', $email)->first();

        if (!$usuario || !password_verify($password, $usuario['password'])) {
            return redirect()->back()->with('error', 'Datos incorrectos');
        }

        session()->set([
            'id_usuario' => $usuario['id'],
            'nombre' => $usuario['nombre'],
            'email' => $usuario['email'],
            'rol' => $usuario['rol'],
            'logged_in' => true,
        ]);

        return redirect()->to(base_url('vistaprincipal'));
    }

    public function cambiarPassword()
    {
        return view('cambiar-password');
    }

    public function actualizarPassword()
    {
        $model = new UsuarioModel();

        $email = $this->request->getPost('email');
        $pass1 = $this->request->getPost('password');
        $pass2 = $this->request->getPost('password2');

        if (!$email || !$pass1 || !$pass2) {
            return redirect()->back()->with('error', 'Completa todos los campos');
        }

        if ($pass1 !== $pass2) {
            return redirect()->back()->with('error', 'Las contraseñas no coinciden');
        }

        $usuario = $model->where('email', $email)->first();

        if (!$usuario) {
            return redirect()->back()->with('error', 'Email no registrado');
        }

        $model->update($usuario['id'], [
            'password' => password_hash($pass1, PASSWORD_DEFAULT)
        ]);

        return redirect()->to('/login')->with('ok', 'Contraseña actualizada');
    }
}