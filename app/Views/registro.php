<?php
// app/Views/registro.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Sistema de Monitoreo de CO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }

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
            padding: 60px 50px;
            border-radius: 28px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 30px 70px -15px rgba(0,0,0,0.6);
            border: 1px solid rgba(56,189,248,0.2);
        }

        .logo-small {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #38bdf8, #0ea5e9);
            border-radius: 50%;
            margin: 0 auto 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            box-shadow: 0 10px 30px rgba(56,189,248,0.4);
        }

        h2 {
            font-size: 32px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 8px;
            background: linear-gradient(90deg, #e0f2fe, #bae6fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .subtitle {
            text-align: center;
            color: #94a3b8;
            font-size: 16px;
            margin-bottom: 40px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 22px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 14px;
            font-weight: 500;
            color: #cbd5e1;
            margin-bottom: 8px;
        }

        input {
            padding: 16px 18px;
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid rgba(148, 163, 184, 0.3);
            border-radius: 12px;
            color: white;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #38bdf8;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2);
            background: rgba(30, 41, 59, 0.95);
        }

        button {
            margin-top: 10px;
            padding: 18px;
            background: linear-gradient(135deg, #38bdf8, #0ea5e9);
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s ease;
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(14, 165, 233, 0.4);
        }

        .link {
            text-align: center;
            margin-top: 30px;
            color: #94a3b8;
            font-size: 15px;
        }

        .link a {
            color: #38bdf8;
            text-decoration: none;
        }

        .link a:hover {
            text-decoration: underline;
        }

        .error {
            color: #f87171;
            font-size: 14px;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="card">
    


    <h2>Crear Cuenta</h2>
    <p class="subtitle">Únase al sistema de monitoreo de monóxido de carbono</p>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="error">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('registro') ?>" method="post">
        
        <div class="input-group">
            <label for="nombre">Nombre completo</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>

        <div class="input-group">
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="input-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required minlength="6">
        </div>

        <button type="submit">Crear cuenta</button>
    </form>

    <div class="link">
        ¿Ya tienes una cuenta? 
        <a href="<?= site_url('login') ?>">Iniciar sesión</a>
    </div>

</div>

</body>
</html>