<!-- app/Views/login.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - Sistema de Detección de CO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
            padding: 55px 50px;
            border-radius: 28px;
            width: 460px;
            text-align: center;
            box-shadow: 0 30px 70px -15px rgba(0,0,0,0.6);
            border: 1px solid rgba(56,189,248,0.2);
            position: relative;
        }

        .btn-back {
            position: absolute;
            top: 25px;
            left: 25px;
            background: rgba(148, 163, 184, 0.2);
            color: #94a3b8;
            border: 1px solid rgba(148,163,184,0.4);
            padding: 10px 16px;
            border-radius: 12px;
            font-size: 14px;
            text-decoration: none;
        }

        .btn-back:hover {
            background: rgba(148, 163, 184, 0.3);
            color: white;
        }

        .logo-box {
            margin-bottom: 25px;
            display:flex;
            justify-content:center;
        }

        .logo-icon {
            width: 120px;
            height: 120px;
            border-radius: 24px;
            background: rgba(56, 189, 248, 0.15);
            border: 1px solid rgba(56, 189, 248, 0.4);
            display:flex;
            align-items:center;
            justify-content:center;
            box-shadow: 0 20px 50px rgba(56,189,248,0.25);
            backdrop-filter: blur(10px);
        }

        h1 {
            font-size: 30px;
            font-weight: 700;
            background: linear-gradient(90deg, #e0f2fe, #bae6fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 8px;
        }

        .subtitle {
            font-size: 16px;
            color: #94a3b8;
            margin-bottom: 35px;
        }

        .form-group {
            margin-bottom: 22px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            font-weight: 500;
            color: #cbd5e1;
        }

        input {
            width: 100%;
            padding: 15px 16px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(148,163,184,0.3);
            border-radius: 12px;
            font-size: 15px;
            color: white;
        }

        input:focus {
            outline: none;
            border-color: #38bdf8;
            background: rgba(255,255,255,0.12);
            box-shadow: 0 0 0 3px rgba(56,189,248,0.15);
        }

        .forgot-password {
            text-align: right;
            margin-top: -10px;
            margin-bottom: 20px;
        }

        .forgot-password a {
            font-size: 14px;
            color: #38bdf8;
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        button {
            width: 100%;
            padding: 15px;
            margin-top: 10px;
            background: linear-gradient(135deg, #38bdf8, #0ea5e9);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(14,165,233,0.4);
        }

        .error {
            color: #fca5a5;
            background: rgba(248, 113, 113, 0.15);
            padding: 10px 14px;
            border-radius: 10px;
            border-left: 4px solid #f87171;
            margin-bottom: 20px;
            text-align: left;
            font-size: 14px;
        }

        .footer {
            margin-top: 25px;
            font-size: 14px;
            color: #94a3b8;
        }

        .footer a {
            color: #38bdf8;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="card">

    <a href="<?= base_url('/') ?>" class="btn-back">← Volver</a>

    <div class="logo-box">
        <div class="logo-icon">
            <i class="fas fa-cloud-sun" style="font-size: 56px; color:#38bdf8;"></i>
        </div>
    </div>

    <h1>Iniciar Sesión</h1>
    <p class="subtitle">
        Ingresa tus credenciales para acceder al sistema de monitoreo
    </p>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="error">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('login/checkLogin') ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="username">Correo Electrónico</label>
            <input type="email"
                   id="username"
                   name="username"
                   placeholder="ejemplo@gmail.com"
                   required
                   autofocus>
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password"
                   id="password"
                   name="password"
                   placeholder="Mínimo 8 caracteres"
                   minlength="8"
                   required>
        </div>

       <div class="forgot"> <a href="<?= base_url('recuperar-password') ?>"> ¿Olvidaste tu contraseña? </a> </div>
        <button type="submit">Iniciar Sesión</button>
    </form>

    <div class="footer">
        ¿No tienes cuenta?
        <a href="<?= base_url('registro') ?>">Regístrate aquí</a>
    </div>

</div>

</body>
</html>