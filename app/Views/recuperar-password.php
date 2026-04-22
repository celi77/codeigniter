<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña - Sistema de Detección de CO</title>
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
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-back:hover {
            background: rgba(148, 163, 184, 0.3);
            color: white;
        }

        .logo {
            width: 180px;
            margin-bottom: 30px;
            filter: drop-shadow(0 15px 35px rgba(56,189,248,0.4));
        }

        h1 {
            font-size: 32px;
            font-weight: 700;
            background: linear-gradient(90deg, #e0f2fe, #bae6fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 8px;
        }

        .subtitle {
            font-size: 17px;
            color: #94a3b8;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 22px;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 16px 18px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(148,163,184,0.3);
            border-radius: 14px;
            font-size: 16px;
            color: white;
        }

        input:focus {
            outline: none;
            border-color: #38bdf8;
            background: rgba(255,255,255,0.12);
            box-shadow: 0 0 0 4px rgba(56,189,248,0.15);
        }

        button {
            width: 100%;
            padding: 17px;
            margin-top: 15px;
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
            box-shadow: 0 15px 30px rgba(14,165,233,0.4);
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

        .footer a:hover {
            text-decoration: underline;
        }

        /* MENSAJES */
        .ok {
            background: rgba(34, 197, 94, 0.2);
            color: #22c55e;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .error {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

    </style>
</head>
<body>

<div class="card">

    <a href="<?= base_url('login') ?>" class="btn-back">← Volver</a>

    <img src="<?= base_url('assets/img/logo-co.jpg') ?>" alt="Logo" class="logo">

    <h1>Recuperar Contraseña</h1>

    <p class="subtitle">
        Ingresa tu correo electrónico y te enviaremos instrucciones para restablecer tu contraseña.
    </p>

    <!-- MENSAJES -->
    <?php if (session()->getFlashdata('ok')): ?>
        <div class="ok">
            <?= session()->getFlashdata('ok') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="error">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- FORM -->
    <form action="<?= base_url('recuperarpassword/enviar') ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <input type="email" name="email" placeholder="tu@email.com" required>
        </div>

        <button type="submit">Enviar gmail</button>
    </form>

    <div class="footer">
        ¿Recordaste tu contraseña? <a href="<?= base_url('login') ?>">Inicia sesión aquí</a>
    </div>

</div>

</body>
</html>