<!-- app/Views/registro.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrarse - Sistema de Detección de CO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 18px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            color: #cbd5e1;
        }

        .input-wrapper {
            position: relative;
        }

        input {
            width: 100%;
            padding: 14px 16px;
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

        .toggle-btn {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            font-size: 16px;
        }

        button[type="submit"] {
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

        button[type="submit"]:hover {
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
            font-size: 14px;
            text-align: left;
        }

        .password-error {
            font-size: 13px;
            color: #f87171;
            margin-top: 6px;
            display: none;
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

    <!-- 🔥 LOGO REEMPLAZADO -->
    <div style="margin-bottom: 25px; display:flex; justify-content:center;">
        <div style="
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
        "><i class="fas fa-cloud-sun" style="font-size: 56px; color:#38bdf8;"></i>
        </div>
    </div>

    <h1>Crear Cuenta</h1>
    <p class="subtitle">
        Regístrate para acceder al sistema de monitoreo de CO
    </p>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="error">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('registro/store') ?>" method="post" onsubmit="return validarPasswords()">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="username">Usuario</label>
            <input type="text" id="username" name="username"
                   placeholder="Elige un usuario"
                   minlength="3"
                   required>
        </div>

        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email"
                   placeholder="ejemplo@correo.com"
                   required>
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <div class="input-wrapper">
                <input type="password" id="password" name="password"
                       placeholder="Mínimo 8 caracteres, una mayúscula y un número"
                       pattern="^(?=.*[A-Z])(?=.*[0-9]).{8,}$"
                       required>
                <button type="button" class="toggle-btn" onclick="togglePassword('password', this)">👁</button>
            </div>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirmar Contraseña</label>
            <div class="input-wrapper">
                <input type="password" id="confirm_password" name="confirm_password"
                       placeholder="Repite la contraseña"
                       required>
                <button type="button" class="toggle-btn" onclick="togglePassword('confirm_password', this)">👁</button>
            </div>
            <div id="password-error" class="password-error">
                Las contraseñas no coinciden.
            </div>
        </div>

        <button type="submit">Registrarse</button>
    </form>

    <div class="footer">
        ¿Ya tienes cuenta? <a href="<?= base_url('login') ?>">Inicia sesión aquí</a>
    </div>

</div>

<script>
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    input.type = input.type === "password" ? "text" : "password";
}

function validarPasswords() {
    const pass = document.getElementById("password").value;
    const confirm = document.getElementById("confirm_password").value;
    const error = document.getElementById("password-error");

    if (pass !== confirm) {
        error.style.display = "block";
        return false;
    }

    error.style.display = "none";
    return true;
}
</script>

</body>
</html>