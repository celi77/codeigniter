<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nombre',
        'email',
        'password',
        'rol',
        'creado_en'
    ];

    // 🔥 IMPORTANTE: asegura conexión y evita errores silenciosos
    protected $useTimestamps = false;
    protected $returnType = 'array';
}