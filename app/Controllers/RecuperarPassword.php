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

    public function enviar()
    {
        helper(['form']);

        $emailUsuario = $this->request->getPost('email');

        if (!$emailUsuario) {
            return redirect()->back()->with('error', 'Ingresá un email válido');
        }

        $model = new RecuperarContrasenaModel();
        $usuarioModel = new UsuarioModel();

        // Verificar usuario
        $usuario = $usuarioModel->where('email', $emailUsuario)->first();

        if (!$usuario) {
            return redirect()->back()->with('error', 'El email no está registrado');
        }

        $token = bin2hex(random_bytes(32));

        $model->insert([
            'email' => $emailUsuario,
            'token' => $token,
            'estado' => 'pendiente'
        ]);

        // =========================
        // EMAIL CONFIG
        // =========================
        $email = \Config\Services::email();

        $email->setFrom('deteccionco@gmail.com', 'Sistema CO');
        $email->setTo($emailUsuario);
        $email->setSubject('Recuperación de contraseña');

        $link = base_url("recuperarpassword/cambiar/$token");

        // =========================
        // MENSAJE ESTÉTICO CON BOTÓN
        // =========================
        $mensaje = "
        <div style='font-family:Arial; background:#0f172a; padding:25px; border-radius:12px; color:white; text-align:center;'>

            <h2 style='color:#38bdf8;'>Recuperación de contraseña</h2>

            <p style='color:#cbd5e1; font-size:15px;'>
                Recibimos una solicitud para restablecer tu contraseña.
            </p>

            <p style='color:#cbd5e1; font-size:15px;'>
                Hacé click en el botón para continuar:
            </p>

            <a href='$link'
                style='display:inline-block; margin-top:20px; padding:12px 22px;
                background:#38bdf8; color:#0f172a; text-decoration:none;
                border-radius:8px; font-weight:bold;'>
                Restablecer contraseña
            </a>

            <p style='margin-top:25px; font-size:12px; color:#94a3b8;'>
                Si no solicitaste esto, ignorá este correo.
            </p>

        </div>
        ";

        $email->setMessage($mensaje);

        if ($email->send()) {
            return redirect()->back()->with('ok', '✔ Te enviamos un correo para recuperar tu contraseña');
        } else {
            return redirect()->back()->with('error', '❌ Error al enviar el correo');
        }
    }

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

    public function actualizar()
    {
        $token = $this->request->getPost('token');
        $nuevaPassword = $this->request->getPost('password');

        if (!$token || !$nuevaPassword) {
            return redirect()->to('/login');
        }

        $model = new RecuperarContrasenaModel();
        $usuarioModel = new UsuarioModel();

        $solicitud = $model
            ->where('token', $token)
            ->where('estado', 'pendiente')
            ->first();

        if (!$solicitud) {
            return redirect()->to('/login')->with('error', 'Token inválido o expirado');
        }

        $usuarioModel->where('email', $solicitud['email'])
            ->set([
                'password' => password_hash($nuevaPassword, PASSWORD_DEFAULT)
            ])
            ->update();

        $model->where('token', $token)
            ->set(['estado' => 'usado'])
            ->update();

        return redirect()->to('/login')->with('ok', 'Contraseña actualizada correctamente');
    }
}