<?php
// app/Views/vistabienvenida.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Detección de CO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at top, #0b1220, #050814);
            color: #e5e7eb;
            overflow-x: hidden;
        }

        .bg-glow {
            position: absolute;
            width: 600px;
            height: 600px;
            background: rgba(56,189,248,0.15);
            filter: blur(120px);
            border-radius: 50%;
            top: -200px;
            left: -200px;
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {
            0%,100% { transform: translateY(0px); }
            50% { transform: translateY(30px); }
        }

        .hero {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            padding: 20px;
        }

        .card-hero {
            position: relative;
            max-width: 750px;
            width: 100%;
            padding: 70px 50px;
            border-radius: 28px;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(56,189,248,0.2);
            box-shadow: 0 40px 90px rgba(0,0,0,0.6);
            text-align: center;
        }

        /* 🔥 ICONO ORIGINAL */
        .logo-box {
            margin-bottom: 25px;
        }

        .logo-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100px;
            height: 100px;
            border-radius: 20px;
            background: rgba(56,189,248,0.1);
            box-shadow: 0 10px 30px rgba(56,189,248,0.2);
        }

        h1 {
            font-size: 42px;
            font-weight: 700;
            background: linear-gradient(90deg, #e0f2fe, #38bdf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        p {
            font-size: 18px;
            color: #94a3b8;
            margin-top: 15px;
            line-height: 1.7;
        }

        .mini-info {
            margin-top: 20px;
            font-size: 15px;
            color: #94a3b8;
        }

        .mini-info i {
            color: #38bdf8;
            margin-right: 6px;
        }

        .btn-custom {
            padding: 14px 22px;
            border-radius: 14px;
            font-weight: 600;
            transition: 0.3s;
            border: none;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #38bdf8, #0ea5e9);
            color: white;
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(14,165,233,0.4);
        }

        .btn-outline-custom {
            background: transparent;
            border: 1px solid rgba(148,163,184,0.4);
            color: #e5e7eb;
        }

        .btn-outline-custom:hover {
            background: rgba(148,163,184,0.15);
        }

        .btn-group-custom {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 40px;
            flex-wrap: wrap;
        }

    </style>
</head>
<body>

<div class="bg-glow"></div>

<div class="hero">

    <div class="card-hero">

        <!-- 🔥 TU ICONO ORIGINAL -->
        <div class="logo-box">
            <div class="logo-icon">
                <i class="fas fa-cloud-sun" style="font-size: 56px; color:#38bdf8;"></i>
            </div>
        </div>

        <h1>Sistema de Detección de CO</h1>

        <p>
            Plataforma inteligente de monitoreo en tiempo real para la detección de monóxido de carbono,
            con alertas automáticas y visualización de datos.
        </p>

        <!-- INFO SIMPLE -->
        <div class="mini-info">
            <p><i class="fas fa-check-circle"></i> Monitoreo en tiempo real</p>
            <p><i class="fas fa-bell"></i> Alertas ante niveles peligrosos</p>
            <p><i class="fas fa-chart-line"></i> Visualización de datos</p>
        </div>

        <div class="btn-group-custom">
            <a href="<?= base_url('registro') ?>">
                <button class="btn btn-custom btn-primary-custom">
                    <i class="fas fa-user-plus me-2"></i> Registrarse
                </button>
            </a>

            <a href="<?= site_url('login') ?>">
                <button class="btn btn-custom btn-outline-custom">
                    <i class="fas fa-sign-in-alt me-2"></i> Iniciar sesión
                </button>
            </a>
        </div>

    </div>

</div>

</body>
</html>