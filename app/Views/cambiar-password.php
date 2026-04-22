<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva contraseña</title>
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
            padding: 55px 50px;
            border-radius: 28px;
            width: 420px;
            text-align: center;
            box-shadow: 0 30px 70px -15px rgba(0,0,0,0.6);
            border: 1px solid rgba(56,189,248,0.2);
            position: relative;
        }

        h2 {
            font-size: 26px;
            margin-bottom: 25px;
            color: #38bdf8;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 8px;
            font-size: 14px;
            color: #cbd5e1;
        }

        input {
            width: 100%;
            padding: 15px;
            border-radius: 12px;
            border: 1px solid rgba(148,163,184,0.3);
            background: rgba(255,255,255,0.08);
            color: white;
            font-size: 15px;
            margin-bottom: 20px;
        }

        input:focus {
            outline: none;
            border-color: #38bdf8;
            box-shadow: 0 0 0 4px rgba(56,189,248,0.15);
        }

        button {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #38bdf8, #0ea5e9);
            color: #0f172a;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(14,165,233,0.4);
        }

        .back {
            position: absolute;
            top: 20px;
            left: 20px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 13px;
        }

        .back:hover {
            color: white;
        }

    </style>
</head>

<body>

<div class="card">

    <a class="back" href="<?= base_url('login') ?>">← Volver</a>

    <h2>Crear nueva contraseña</h2>

    <form method="post" action="<?= base_url('recuperarpassword/actualizar') ?>">
        <?= csrf_field() ?>

        <input type="hidden" name="token" value="<?= $token ?>">

        <label>Nueva contraseña</label>
        <input type="password" name="password" placeholder="Ingresá tu nueva contraseña" required>

        <button type="submit">Guardar contraseña</button>
    </form>

</div>

</body>
</html>