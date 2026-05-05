<?php

namespace App\Controllers;

use App\Models\RecuperarContrasenaModel;
use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class RecuperarPassword extends Controller
{
    public function index()
    {
        return view('recuperar-password');
    }

    // 📩 SOLO CREA SOLICITUD (SIN MAIL)
    public function enviar()
    {
        helper(['form']);

        $emailUsuario = $this->request->getPost('email');

        if (!$emailUsuario) {
            return redirect()->back()->with('error', 'Ingresá un email válido');
        }

        $model = new RecuperarContrasenaModel();
        $usuarioModel = new UsuarioModel();

        // 🔍 verificar usuario
        $usuario = $usuarioModel->where('email', $emailUsuario)->first();

        if (!$usuario) {
            return redirect()->back()->with('error', 'El email no está registrado');
        }

        $token = bin2hex(random_bytes(32));

        // 💾 guardar solicitud (IMPORTANTE)
        $model->insert([
            'email' => $emailUsuario,
            'token' => $token,
            'estado' => 'pendiente'
        ]);

        return redirect()->back()->with('ok', 'Solicitud enviada. El administrador la revisará.');
    }

    // 🔑 LINK DEL MAIL (LO USA EL ADMIN APROBADO)
    public function cambiar($token)
    {
        $model = new RecuperarContrasenaModel();

        $solicitud = $model
            ->where('token', $token)
            ->where('estado', 'pendiente')
            ->first();

        if (!$solicitud) {
            return redirect()->to('/login')->with('error', 'Token inválido o ya utilizado');
        }

        return view('cambiar-password', ['token' => $token]);
    }

    // 🔐 ACTUALIZAR CONTRASEÑA
    public function actualizar()
    {
        $token = $this->request->getPost('token');
        $nuevaPassword = $this->request->getPost('password');

        if (!$token || !$nuevaPassword) {
            return redirect()->to('/login');
        }

        $model = new RecuperarContrasenaModel();
        $usuarioModel = new UsuarioModel();

        // 🔍 validar token
        $solicitud = $model
            ->where('token', $token)
            ->where('estado', 'pendiente')
            ->first();

        if (!$solicitud) {
            return redirect()->to('/login')->with('error', 'Token inválido o expirado');
        }

        // 🔄 actualizar usuario
        $usuarioModel->where('email', $solicitud['email'])
            ->set([
                'password' => password_hash($nuevaPassword, PASSWORD_DEFAULT)
            ])
            ->update();

        // 🚫 invalidar token
        $model->where('token', $token)
            ->set(['estado' => 'usado'])
            ->update();

        return redirect()->to('/login')->with('ok', 'Contraseña actualizada correctamente');
    }
}