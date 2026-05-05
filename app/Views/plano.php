<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Actividad de Sensores</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&family=DM+Sans:300;400;500&display=swap" rel="stylesheet">

<style>
:root {
  --blue:#38bdf8;
  --bg:#050814;
  --card:rgba(10,16,34,.85);
  --border:rgba(56,189,248,.1);
  --text:#e2e8f0;
  --muted:#64748b;
}

/* BASE */
body{
  background: var(--bg);
  color: var(--text);
  font-family:'DM Sans',sans-serif;
}

/* SIDEBAR */
.sidebar{
  position:fixed;
  width:240px;
  height:100vh;
  background:rgba(8,13,28,.9);
  border-right:1px solid var(--border);
  padding:20px;
}

.sidebar a{
  display:block;
  padding:10px;
  border-radius:10px;
  color:#94a3b8;
  text-decoration:none;
  margin-bottom:5px;
}

.sidebar a:hover{
  background:rgba(56,189,248,.08);
  color:var(--blue);
}

/* MAIN */
.main{
  margin-left:240px;
  padding:30px;
}

/* CARD */
.card-glass{
  background:var(--card);
  border:1px solid var(--border);
  border-radius:18px;
  backdrop-filter:blur(20px);
}

/* SENSOR ITEM */
.sensor{
  display:flex;
  justify-content:space-between;
  align-items:center;
  padding:15px 20px;
  border-bottom:1px solid var(--border);
}

.sensor:last-child{ border-bottom:none; }

.sensor-name{
  font-size:14px;
}

.badge-state{
  padding:6px 12px;
  border-radius:100px;
  font-size:12px;
}

/* ESTADOS */
.activo{
  background:rgba(34,197,94,.15);
  color:#4ade80;
}

.mantenimiento{
  background:rgba(250,204,21,.15);
  color:#fde047;
}

.apagado{
  background:rgba(239,68,68,.15);
  color:#f87171;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <h5 style="color:var(--blue)">CO Monitor</h5>

  <a href="<?= base_url('vistaprincipal') ?>"><i class="fas fa-home"></i> Inicio</a>
  <a href="<?= base_url('plano') ?>"><i class="fas fa-map"></i> Ubicación</a>
  <a href="<?= base_url('estadisticas') ?>"><i class="fas fa-chart-bar"></i> Estadísticas</a>
  <a href="<?= base_url('alertas') ?>"><i class="fas fa-bell"></i> Alertas</a>

  <hr style="border-color:var(--border)">

  <a href="<?= base_url('miperfil') ?>"><i class="fas fa-user"></i> Mi Perfil</a>
  <a href="<?= base_url('logout') ?>" style="color:#f87171;"><i class="fas fa-sign-out-alt"></i> Salir</a>
</div>

<!-- MAIN -->
<div class="main">

  <h3 style="font-family:'Syne';margin-bottom:20px;">
    <i class="fas fa-microchip" style="color:var(--blue)"></i>
    Actividad de Sensores
  </h3>

  <div class="card-glass">

    <?php if (!empty($sensores)): ?>

      <?php foreach ($sensores as $sensor): ?>

        <div class="sensor">

          <div class="sensor-name">
            Sensor <?= esc($sensor['id']) ?> - <?= esc($sensor['sector']) ?>
          </div>

          <span class="badge-state <?= esc($sensor['funcionamiento']) ?>">
            <?= esc($sensor['funcionamiento']) ?>
          </span>

        </div>

      <?php endforeach; ?>

    <?php else: ?>

      <div style="padding:20px;color:var(--muted)">
        No hay sensores en la base de datos.
      </div>

    <?php endif; ?>

  </div>

</div>

</body>
</html>