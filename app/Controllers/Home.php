<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends Controller
{
    public function index()
    {
        // Esto es seguro, mínimo y funciona siempre
        if (file_exists(APPPATH.'Views/vistaprincipal.php')) {
            return view('vistaprincipal');
        } else {
            // Si no encuentra la vista, mostramos un mensaje simple
            echo "No se encontró la vista 'vistaprincipal.php'";
        }
    }
}