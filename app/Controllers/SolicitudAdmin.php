<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class SolicitudAdmin extends Controller
{
    public function index()
    {
        return view('solicitud_admin');
    }

    public function enviar()
    {
        $email = \Config\Services::email();

        $nombre = session()->get('nombre');
        $userEmail = session()->get('email');
        $motivo = $this->request->getPost('motivo');

        $email->setFrom($userEmail, $nombre);
        $email->setTo('detecciondeco@gmail.com');
        $email->setSubject('Solicitud de administrador');

        $email->setMailType('html');

        $email->setMessage("
        <html>
        <body style='font-family:Arial;background:#0b1220;color:#e2e8f0;padding:20px'>
          <div style='max-width:600px;margin:auto;background:#111827;padding:20px;border-radius:12px'>
            <h2 style='color:#38bdf8'>Nueva solicitud de administrador</h2>

            <p><b>Nombre:</b> $nombre</p>
            <p><b>Email:</b> $userEmail</p>

            <div style='margin-top:10px'>
              <b>Motivo:</b>
              <div style='background:#0f172a;padding:10px;border-radius:8px;margin-top:5px'>
                $motivo
              </div>
            </div>

          </div>
        </body>
        </html>
        ");

        // 🔥 ENVÍO
        if ($email->send()) {
            return redirect()->back()->with('ok', 'Solicitud enviada correctamente');
        } else {
            return redirect()->back()->with('ok', 'Error al enviar la solicitud');
        }
    }
}