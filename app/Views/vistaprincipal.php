<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vista General - CO System</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

  <style>
    body {
      background: #0f172a;
      font-family: 'Segoe UI', sans-serif;
      color: #e2e8f0;
    }

    h1,h2,h3,h4,h5,h6,strong { color:#f8fafc !important; }
    small,.text-muted { color:#cbd5e1 !important; }

    .sidebar {
      background: #111827;
      height: 100vh;
      position: fixed;
      width: 250px;
      border-right: 1px solid #1f2937;
    }

    .sidebar a {
      color: #e5e7eb;
      padding: 14px 22px;
      display: block;
      text-decoration: none;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background: #1e293b;
      color: #38bdf8;
    }

    .main-content {
      margin-left: 250px;
      padding: 35px;
    }

    .header {
      background: #1e293b;
      padding: 18px 30px;
      border-radius: 16px;
      margin-bottom: 25px;
      border: 1px solid #1f2937;
    }

    .card {
      background: #1e293b;
      border: 1px solid #1f2937;
      border-radius: 15px;
      color: #e2e8f0;
    }

    /* KPI */
    .kpi-card { padding:20px; text-align:center; }

    .kpi-blue { border-top:3px solid #38bdf8; }
    .kpi-green { border-top:3px solid #22c55e; }
    .kpi-yellow { border-top:3px solid #facc15; }
    .kpi-red { border-top:3px solid #ef4444; }

    .kpi-card h2 {
      font-size: 26px;
      font-weight: bold;
    }

    /* ACTIVIDAD */
    .activity-item {
      border-bottom: 1px solid #1f2937;
      padding: 10px 0;
    }

    .badge-soft {
      font-size: 12px;
      padding: 4px 8px;
      border-radius: 6px;
    }

    .ok { background:rgba(34,197,94,0.15); color:#22c55e; }
    .warn { background:rgba(250,204,21,0.15); color:#facc15; }
    .bad { background:rgba(239,68,68,0.15); color:#ef4444; }
  </style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

  <div class="p-4 text-center border-bottom">
    <h4 class="text-primary">Detección de CO</h4>
    <small>Sistema de Sensores</small>
  </div>

  <a href="#" class="active"><i class="fas fa-home me-2"></i> Vista General</a>
  <a href="<?= base_url('plano') ?>"><i class="fas fa-map me-2"></i> Ubicación</a>
  <a href="<?= base_url('estadisticas') ?>"><i class="fas fa-chart-bar me-2"></i> Estadísticas</a>
  <a href="<?= base_url('alertas') ?>"><i class="fas fa-bell me-2"></i> Alertas</a>

  <?php if(session()->get('rol') === 'admin'): ?>
    <a href="<?= base_url('configuracion') ?>"><i class="fas fa-cog me-2"></i> Configuración</a>
  <?php endif; ?>

  <div class="position-absolute bottom-0 w-100 p-3">
    <a href="<?= base_url('miperfil') ?>"><i class="fas fa-user me-2"></i> Mi Perfil</a>
    <a href="<?= base_url('/') ?>" class="text-danger"><i class="fas fa-sign-out-alt me-2"></i> Salir</a>
  </div>

</div>

<!-- MAIN -->
<div class="main-content">

  <!-- HEADER CON LOGO AGREGADO -->
  <div class="header d-flex justify-content-between align-items-center">

    <h3>Vista General</h3>

    <div class="d-flex align-items-center gap-3">

      <!-- 🔥 LOGO PEQUEÑO -->
      <div style="
          width: 38px;
          height: 38px;
          border-radius: 10px;
          background: rgba(56, 189, 248, 0.15);
          border: 1px solid rgba(56, 189, 248, 0.4);
          display:flex;
          align-items:center;
          justify-content:center;
          box-shadow: 0 10px 25px rgba(56,189,248,0.25);
      ">
          <i class="fas fa-cloud-sun" style="font-size: 18px; color:#38bdf8;"></i>
      </div>

      <div>
        Hola, <strong><?= session()->get('nombre'); ?></strong>
      </div>

    </div>

  </div>

  <!-- KPI -->
  <div class="row g-4">

    <div class="col-md-3">
      <div class="card kpi-card kpi-blue">
        <h6>Total Sensores</h6>
        <h2 class="text-info">24</h2>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card kpi-card kpi-red">
        <h6>Alertas</h6>
        <h2 class="text-danger">3</h2>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card kpi-card kpi-yellow">
        <h6>Temperatura</h6>
        <h2 class="text-warning">22.8°C</h2>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card kpi-card kpi-green">
        <h6>Estado</h6>
        <h2 class="text-success">NORMAL</h2>
      </div>
    </div>

  </div>

  <!-- ACTIVIDAD -->
  <div class="card p-4 mt-4">

    <h5 class="mb-3"><i class="fas fa-microchip me-2"></i>Actividad de Sensores</h5>

    <div class="activity-item">
      Sensor Sala 1 - 21.4°C
      <span class="float-end badge-soft ok">Activo</span>
    </div>

    <div class="activity-item">
      Sensor Sala 3 - 32.5°C
      <span class="float-end badge-soft bad">Alerta</span>
    </div>

    <div class="activity-item">
      Sensor Cocina - Gas detectado
      <span class="float-end badge-soft bad">Crítico</span>
    </div>

    <div class="activity-item">
      Sensor Depósito - 55% humedad
      <span class="float-end badge-soft ok">Normal</span>
    </div>

  </div>

</div>

</body>
</html>