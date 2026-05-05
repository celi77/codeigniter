<!-- app/Views/registro.php -->
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registro — CO Monitor</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

<style>

*{margin:0;padding:0;box-sizing:border-box;}

:root{
  --blue:#38bdf8;
  --blue-dk:#0ea5e9;
  --bg:#050814;
  --card:rgba(10,16,34,0.85);
  --border:rgba(56,189,248,0.18);
  --text:#e2e8f0;
  --muted:#64748b;
}

body{
  min-height:100vh;
  display:flex;
  align-items:center;
  justify-content:center;
  background:var(--bg);
  font-family:'DM Sans',sans-serif;
  color:var(--text);
}

/* CARD */
.card{
  width:420px;
  padding:40px;
  border-radius:24px;
  background:var(--card);
  border:1px solid var(--border);
  backdrop-filter:blur(20px);
  box-shadow:0 40px 100px rgba(0,0,0,0.7);
}

/* BACK */
.btn-back{
  display:inline-block;
  margin-bottom:20px;
  font-size:13px;
  color:var(--muted);
  text-decoration:none;
}
.btn-back:hover{color:white;}

/* TITULO */
h1{
  font-family:'Syne';
  font-size:28px;
  margin-bottom:8px;
}

.subtitle{
  color:var(--muted);
  font-size:14px;
  margin-bottom:25px;
}

/* INPUTS */
.input-group{
  margin-bottom:16px;
}

.input-wrapper{
  position:relative;
}

input{
  width:100%;
  padding:12px;
  border-radius:10px;
  border:1px solid rgba(148,163,184,0.2);
  background:rgba(255,255,255,0.05);
  color:white;
}

input:focus{
  border-color:var(--blue);
  outline:none;
}

/* OJO */
.toggle-btn{
  position:absolute;
  right:10px;
  top:50%;
  transform:translateY(-50%);
  background:none;
  border:none;
  color:#94a3b8;
  cursor:pointer;
}

/* BOTON */
.btn{
  width:100%;
  padding:13px;
  border:none;
  border-radius:12px;
  background:linear-gradient(135deg,var(--blue),var(--blue-dk));
  color:white;
  cursor:pointer;
  font-weight:600;
}

.btn:hover{
  transform:translateY(-2px);
}

/* ERROR */
.error{
  background:#f8717120;
  padding:10px;
  border-radius:8px;
  color:#fca5a5;
  margin-bottom:10px;
}

/* PASSWORD ERROR */
.password-error{
  font-size:13px;
  color:#f87171;
  margin-top:6px;
  display:none;
}

/* LINKS */
.links{
  margin-top:15px;
  text-align:center;
}

.links a{
  color:var(--blue);
  text-decoration:none;
  font-size:13px;
}

</style>
</head>

<body>

<div class="card">

  <a href="<?= base_url('/') ?>" class="btn-back">← Volver</a>

  <h1>Crear cuenta</h1>
  <p class="subtitle">Registrate en el sistema de monitoreo</p>

  <?php if(session()->getFlashdata('error')): ?>
    <div class="error">
      <?= session()->getFlashdata('error') ?>
    </div>
  <?php endif; ?>

  <form action="<?= base_url('registro/store') ?>" method="post" onsubmit="return validarPasswords()">
    <?= csrf_field() ?>

    <div class="input-group">
      <input type="text" name="username" placeholder="Usuario" minlength="3" required>
    </div>

    <div class="input-group">
      <input type="email" name="email" placeholder="Correo" required>
    </div>

    <div class="input-group">
      <div class="input-wrapper">
        <input type="password" id="password" name="password"
          placeholder="Mínimo 8 caracteres, 1 mayúscula y 1 número"
          pattern="^(?=.*[A-Z])(?=.*[0-9]).{8,}$"
          required>
        <button type="button" class="toggle-btn" onclick="togglePassword('password')">👁</button>
      </div>
    </div>

    <div class="input-group">
      <div class="input-wrapper">
        <input type="password" id="confirm_password" name="confirm_password"
          placeholder="Confirmar contraseña"
          required>
        <button type="button" class="toggle-btn" onclick="togglePassword('confirm_password')">👁</button>
      </div>
      <div id="password-error" class="password-error">
        Las contraseñas no coinciden
      </div>
    </div>

    <button class="btn" type="submit">Crear cuenta</button>
  </form>

  <div class="links">
    <a href="<?= base_url('login') ?>">¿Ya tenés cuenta? Iniciar sesión</a>
  </div>

</div>

<script>
function togglePassword(id){
  const input=document.getElementById(id);
  input.type=input.type==="password"?"text":"password";
}

function validarPasswords(){
  const p=document.getElementById('password').value;
  const c=document.getElementById('confirm_password').value;
  const error=document.getElementById('password-error');

  if(p!==c){
    error.style.display="block";
    return false;
  }

  error.style.display="none";
  return true;
}
</script>

</body>
</html>