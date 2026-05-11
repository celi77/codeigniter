<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Cambiar contraseña</title>

<style>
body{
    font-family: Arial;
    background:#0f172a;
    color:white;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.card{
    background:#111827;
    padding:40px;
    width:350px;
    border-radius:12px;
}

input{
    width:100%;
    padding:10px;
    margin:10px 0;
}

button{
    width:100%;
    padding:10px;
    background:#38bdf8;
    border:none;
    cursor:pointer;
}

small{
    cursor:pointer;
    color:#38bdf8;
}
</style>
</head>

<body>

<div class="card">

<h2>Cambiar contraseña</h2>

<?php if(session()->getFlashdata('error')): ?>
<p style="color:red"><?= session()->getFlashdata('error') ?></p>
<?php endif; ?>

<form method="post" action="<?= base_url('cambiar-password/actualizar') ?>">
<?= csrf_field() ?>

<label>Email</label>
<input type="email" name="email" required>

<label>Nueva contraseña</label>
<input type="password" name="password" id="p1" required>

<label>Repetir contraseña</label>
<input type="password" name="password2" id="p2" required>

<small onclick="toggle()">ver contraseña 👁️</small>

<br><br>

<button type="submit">Guardar</button>

</form>

</div>

<script>
function toggle(){
    let a=document.getElementById('p1');
    let b=document.getElementById('p2');

    a.type = a.type==="password"?"text":"password";
    b.type = b.type==="password"?"text":"password";
}
</script>

</body>
</html>