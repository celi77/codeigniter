<?php

namespace App\Models;

use CodeIgniter\Model;

class RecuperarContrasenaModel extends Model
{
    protected $table = 'recuperar_contrasena';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'email',
        'token',
        'estado',
        'created_at'
    ];
}