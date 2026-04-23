<?php

namespace App\Controllers;

use App\Models\RecuperarContrasenaModel;
use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class SolPass extends Controller
{
    // 🔐 VALIDAR ADMIN
    private function checkAdmin()
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to(base_url('vistaprincipal'));
        }
    }

    // 📋 LISTADO (SOLO ADMIN)
    public function index()
    {
        if ($redir = $this->checkAdmin()) {
            return $redir;
        }

        $model = new RecuperarContrasenaModel();

        $data['solicitudes'] = $model->orderBy('id', 'DESC')->findAll();

        return view('solpass', $data);
    }

    // 📩 SOLICITUD USUARIO
    public function send()
    {
        $model = new RecuperarContrasenaModel();
        $email = $this->request->getPost('email');

        if (!$email) {
            return redirect()->back()->with('error', 'Ingresá un email');
        }

        $token = bin2hex(random_bytes(20));

        $model->save([
            'email' => $email,
            'token' => $token,
            'estado' => 'pendiente'
        ]);

        return redirect()->back()->with('success', 'Solicitud enviada');
    }

    // ✔ APROBAR SOLICITUD
    public function aprobar($id = null)
    {
        if ($redir = $this->checkAdmin()) {
            return $redir;
        }

        $model = new RecuperarContrasenaModel();
        $solicitud = $model->find($id);

        if (!$solicitud) {
            return redirect()->back()->with('error', 'Solicitud no encontrada');
        }

        $model->update($id, ['estado' => 'aprobado']);

        $email = \Config\Services::email();

        $email->setTo($solicitud['email']);
        $email->setSubject('Cambio de contraseña aprobado');

        $mensaje = "
        <div style='font-family: Arial, sans-serif; background:#0f172a; padding:20px; border-radius:10px; color:#e2e8f0; max-width:600px; margin:auto;'>

            <h2 style='color:#38bdf8;'>Solicitud aprobada ✅</h2>

            <p style='font-size:16px;'>
                Tu solicitud de cambio de contraseña fue <b style='color:#22c55e;'>aprobada</b>.
            </p>

            <p style='font-size:15px;'>
                Hacé clic en el botón para continuar:
            </p>

            <a href='".base_url('reset/'.$solicitud['token'])."' 
               style='display:inline-block; padding:12px 20px; margin-top:10px;
               background:#38bdf8; color:#0f172a; text-decoration:none;
               border-radius:8px; font-weight:bold;'>
               Cambiar contraseña
            </a>

            <p style='margin-top:20px; font-size:12px; color:#94a3b8;'>
                Si no solicitaste esto, ignorá este mensaje.
            </p>

        </div>
        ";

        $email->setMessage($mensaje);
        $email->send();

        return redirect()->back()->with('success', 'Solicitud aprobada');
    }

    // ✖ RECHAZAR
    public function rechazar($id)
    {
        if ($redir = $this->checkAdmin()) {
            return $redir;
        }

        $model = new RecuperarContrasenaModel();
        $solicitud = $model->find($id);

        if (!$solicitud) {
            return redirect()->back()->with('error', 'Solicitud no encontrada');
        }

        $model->update($id, ['estado' => 'rechazada']);

        $email = \Config\Services::email();

        $email->setTo($solicitud['email']);
        $email->setSubject('Solicitud rechazada');

        $email->setMessage("
            <div style='font-family: Arial; padding:20px; background:#0f172a; color:#e2e8f0; border-radius:10px;'>
                <h2 style='color:#ef4444;'>Solicitud rechazada ❌</h2>
                <p>Tu solicitud de cambio de contraseña fue rechazada.</p>
                <p>Contactá al administrador si creés que es un error.</p>
            </div>
        ");

        $email->send();

        return redirect()->back()->with('success', 'Solicitud rechazada');
    }

    // 🔑 MOSTRAR VISTA CAMBIAR CONTRASEÑA
    public function reset($token)
    {
        $model = new RecuperarContrasenaModel();

        $solicitud = $model->where('token', $token)
                           ->where('estado', 'aprobado')
                           ->first();

        if (!$solicitud) {
            return redirect()->to(base_url('login'))->with('error', 'Token inválido o expirado');
        }

        return view('cambiar-password', ['token' => $token]);
    }

    // 🔐 ACTUALIZAR CONTRASEÑA
    public function updatePassword()
{
    $model = new \App\Models\RecuperarContrasenaModel();
    $userModel = new \App\Models\UsuarioModel();

    $token = $this->request->getPost('token');
    $password = $this->request->getPost('password');

    $solicitud = $model->where('token', $token)
                       ->where('estado', 'aprobado')
                       ->first();

    if (!$solicitud) {
        return redirect()->to(base_url('login'))->with('error', 'Token inválido');
    }

    $usuario = $userModel->where('email', $solicitud['email'])->first();

    if (!$usuario) {
        return redirect()->to(base_url('login'))->with('error', 'Usuario no encontrado');
    }

    $userModel->update($usuario['id'], [
        'password' => password_hash($password, PASSWORD_DEFAULT)
    ]);

    $model->update($solicitud['id'], [
        'token' => null,
        'estado' => 'usado'
    ]);

    return redirect()->to(base_url('login'))->with('success', 'Contraseña actualizada');
}
}