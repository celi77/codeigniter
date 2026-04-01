<?php
// app/Views/vistabienvenida.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Detección de CO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #0f172a 0%, #1e2937 100%);
            font-family: 'Inter', sans-serif;
            color: white;
        }

        .card {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(24px);
            padding: 70px 60px;
            border-radius: 28px;
            width: 680px;
            text-align: center;
            box-shadow: 0 30px 70px -15px rgba(0,0,0,0.6);
            border: 1px solid rgba(56,189,248,0.2);
        }

        .logo {
            width: 260px;
            margin-bottom: 40px;
            filter: drop-shadow(0 15px 35px rgba(56,189,248,0.4));
        }

        h1 {
            font-size: 38px;
            font-weight: 700;
            background: linear-gradient(90deg, #e0f2fe, #bae6fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 12px;
        }

        .subtitle {
            font-size: 18px;
            color: #94a3b8;
            line-height: 1.65;
            margin-bottom: 55px;
        }

        .botones {
            display: flex;
            gap: 20px;
            justify-content: center;
        }

        .botones a {
            text-decoration: none;
            flex: 1;
            max-width: 260px;
        }

        .botones button {
            width: 100%;
            padding: 18px;
            border: none;
            border-radius: 14px;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s ease;
        }

        .registro { 
            background: linear-gradient(135deg, #38bdf8, #0ea5e9); 
            color: white; 
        }

        .login { 
            background: rgba(148, 163, 184, 0.15); 
            color: white; 
            border: 1px solid rgba(148,163,184,0.4);
        }

        .registro:hover { transform: translateY(-4px); box-shadow: 0 15px 30px rgba(14,165,233,0.4); }
        .login:hover { background: rgba(148, 163, 184, 0.25); }
    </style>
</head>
<body>

<div class="card">
    <img src="<?= base_url('assets/img/logo-co.jpg') ?>" alt="Logo Sistema CO" class="logo">

    <h1>Sistema de Detección de CO</h1>
    <p class="subtitle">
        Plataforma industrial avanzada para el monitoreo en tiempo real de monóxido de carbono.
    </p>

    <div class="botones">
        <a href="<?= site_url('registro') ?>">
            <button class="registro">Registrarse</button>
        </a>
        
        <a href="<?= site_url('login') ?>">
            <button class="login">Iniciar sesión</button>
        </a>
    </div>
</div>

</body>
</html>