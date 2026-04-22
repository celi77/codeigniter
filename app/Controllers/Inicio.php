<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Inicio extends Controller
{
    public function index()
    {
        return view('bienvenida');
    }

    public function registro()
    {
        return view('registro');
    }
    public function login()
    {
        return view('login');
    }   
    public function guardar()
    {
        $nombre = $this->request->getPost('nombre');
        $email = $this->request->getPost('email');
        $pass  = $this->request->getPost('password');

        // 👉 Acá después podés guardar en la BD

        return redirect()->to('/')->with('msg', 'Usuario registrado correctamente');
    }
}