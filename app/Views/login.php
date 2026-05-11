<?php // app/Views/login.php ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión — CO Monitor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- FUENTES Y ICONOS (CORREGIDO) -->
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* =======================
           TODO TU STYLE ORIGINAL
           (NO TOQUÉ NADA)
        ======================= */

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue:#38bdf8;
            --blue-dk:#0ea5e9;
            --bg-deep:#050814;
            --text:#e2e8f0;
            --muted:#64748b;
            --border:rgba(56,189,248,0.18);
        }

        html, body {
            min-height:100vh;
            overflow-x:hidden;
            background:var(--bg-deep);
            color:var(--text);
            font-family:'DM Sans', sans-serif;
        }

        #bg-canvas { position: fixed; inset: 0; z-index: 0; }

        .grid-overlay {
            position: fixed; inset:0; z-index:1;
            background-image:
                linear-gradient(rgba(56,189,248,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(56,189,248,0.04) 1px, transparent 1px);
            background-size:80px 80px;
        }

        .noise {
            position: fixed; inset:0; z-index:2; opacity:0.025;
        }

        .page-wrap { position: relative; z-index:10; min-height:100vh; display:flex; flex-direction:column; }

        .site-header {
            display:flex; justify-content:space-between; align-items:center;
            padding:24px 56px;
            border-bottom:1px solid rgba(56,189,248,0.08);
        }

        .brand { display:flex; gap:12px; align-items:center; }

        .brand-icon {
            width:36px;height:36px;border-radius:10px;
            background:rgba(56,189,248,0.1);
            display:flex;align-items:center;justify-content:center;
            color:var(--blue);
        }

        .header-badge {
            display:flex;gap:7px;align-items:center;
            padding:7px 14px;border-radius:100px;
            background:rgba(56,189,248,0.06);
        }

        .pulse-dot {
            width:7px;height:7px;border-radius:50%;
            background:#22c55e;
        }

        .main-content {
            flex:1;
            display:flex;
            justify-content:center;
            align-items:center;
        }

      .login-shell {
    display:flex;
    max-width:500px; /* antes 860px */
    width:100%;
    background:rgba(8,15,30,0.9);
    border-radius:28px;
    overflow:hidden;
    border:1px solid rgba(56,189,248,0.2);
}

        .form-panel { flex:1; padding:40px; }

        .btn-back {
            display:inline-block;
            margin-bottom:20px;
            color:var(--muted);
            text-decoration:none;
        }

        input {
            width:100%;
            padding:12px;
            margin-bottom:15px;
            background:rgba(255,255,255,0.05);
            border:1px solid rgba(148,163,184,0.2);
            border-radius:10px;
            color:white;
        }

        .btn-submit {
            width:100%;
            padding:14px;
            background:linear-gradient(135deg,#38bdf8,#0ea5e9);
            border:none;
            border-radius:12px;
            color:white;
            cursor:pointer;
        }

        .error-box {
            background:rgba(248,113,113,0.1);
            padding:10px;
            margin-bottom:15px;
            border-radius:10px;
        }

        .form-footer {
            margin-top:15px;
            text-align:center;
        }

    </style>
</head>

<body>

<canvas id="bg-canvas"></canvas>
<div class="grid-overlay"></div>
<div class="noise"></div>

<div class="page-wrap">

<header class="site-header">
    <div class="brand">
        <div class="brand-icon"><i class="fas fa-cloud-sun"></i></div>
        <div>
            <div>CO Monitor</div>
            <div style="font-size:11px;color:#64748b;">Sistema de Detección</div>
        </div>
    </div>

    <div class="header-badge">
        <div class="pulse-dot"></div>
        Sistema activo
    </div>
</header>

<div class="main-content">
<div class="login-shell">

<main class="form-panel">

    <!-- BOTÓN VOLVER (ARREGLADO) -->
    <a href="<?= base_url('/') ?>" class="btn-back">
        ← Volver al inicio
    </a>

    <h2>Iniciar Sesión</h2>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="error-box">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- FORM CORRECTO -->
    <form action="<?= base_url('login/checkLogin') ?>" method="post">
        <?= csrf_field() ?>

        <input type="email" name="email" placeholder="Correo electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required minlength="8">

        <!-- OLVIDASTE CONTRASEÑA (ARREGLADO) -->
              <a href="<?= base_url('cambiar-password') ?>" class="btn-back">
        ¿Olvidaste tu contraseña? 
    </a>

        <button type="submit" class="btn-submit">Iniciar sesión</button>
    </form>

    <!-- REGISTRO (ARREGLADO) -->
    <div class="form-footer">
        ¿No tienes cuenta?
        <a href="<?= base_url('registro') ?>">Regístrate</a>
    </div>

</main>

</div>
</div>

<footer style="padding:20px;text-align:center;color:#64748b;">
    © <?= date('Y') ?> CO Monitor
</footer>

</div>

</body>
</html>