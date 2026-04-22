<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Sensores CO</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: #0d1b2a;
      color: white;
    }

    /* HEADER */
    .header {
      background: #1b263b;
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 20px;
    }

    .btn-volver {
      background: #415a77;
      color: white;
      padding: 6px 12px;
      border-radius: 8px;
      text-decoration: none;
    }

    .btn-volver:hover {
      background: #778da9;
      color: white;
    }

    /* GRID */
    .grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 15px;
    }

    .sensor-card {
      background: #1b263b;
      border-radius: 12px;
      padding: 15px;
      border: 1px solid #415a77;
      transition: 0.3s;
    }

    .sensor-card:hover {
      transform: scale(1.03);
    }

    .estado {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      display: inline-block;
      margin-right: 5px;
    }

    .verde { background: #2ecc71; }
    .amarillo { background: #f1c40f; }
    .rojo { background: #e74c3c; }

    .sidebar {
      background: #1b263b;
      padding: 15px;
      border-radius: 12px;
      border: 1px solid #415a77;
    }
  </style>
</head>

<body>

<div class="container mt-3">

  <!-- HEADER -->
  <div class="header d-flex justify-content-between align-items-center">
    <h4 class="m-0">📡 Sensores de Monóxido de Carbono</h4>

    <a href="<?= base_url('vistaprincipal') ?>" class="btn-volver">
      <i class="fas fa-arrow-left"></i> Volver
    </a>
  </div>

  <div class="row">

    <!-- GRID SENSORES -->
    <div class="col-md-8">

      <div class="grid">

        <!-- SENSOR 1 -->
        <div class="sensor-card">
          <h6>Sensor 1</h6>
          <p><span class="estado verde"></span> Zona: Sala A</p>
          <p>CO: 35 ppm</p>
        </div>

        <!-- SENSOR 2 -->
        <div class="sensor-card">
          <h6>Sensor 2</h6>
          <p><span class="estado amarillo"></span> Zona: Cocina</p>
          <p>CO: 80 ppm</p>
        </div>

        <!-- SENSOR 3 -->
        <div class="sensor-card">
          <h6>Sensor 3</h6>
          <p><span class="estado rojo"></span> Zona: Garaje</p>
          <p>CO: 140 ppm</p>
        </div>

        <!-- SENSOR 4 -->
        <div class="sensor-card">
          <h6>Sensor 4</h6>
          <p><span class="estado verde"></span> Zona: Pasillo</p>
          <p>CO: 20 ppm</p>
        </div>

      </div>

    </div>

    <!-- SIDEBAR -->
    <div class="col-md-4">

      <div class="sidebar">
        <h5>📊 Estado General</h5>
        <hr>

        <p><span class="estado verde"></span> Normal</p>
        <p><span class="estado amarillo"></span> Advertencia</p>
        <p><span class="estado rojo"></span> Peligro</p>

        <hr>

        <p><strong>Total sensores:</strong> 4</p>
        <p><strong>Estado:</strong> OK</p>
      </div>

    </div>

  </div>

</div>

</body>
</html>