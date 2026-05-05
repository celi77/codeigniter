<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Detalle Sensor</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: #0d1b2a;
      color: white;
    }

    .header {
      background: #1b263b;
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 20px;
      border: 1px solid #415a77;
    }

    .card-sensor {
      background: #1b263b;
      border-radius: 12px;
      padding: 25px;
      border: 1px solid #415a77;
    }

    .estado {
      padding: 6px 12px;
      border-radius: 8px;
      font-weight: bold;
      display: inline-block;
    }

    .activado {
      background: #2ecc71;
      color: black;
    }

    .mantenimiento {
      background: #f1c40f;
      color: black;
    }

    .apagado {
      background: #e74c3c;
      color: white;
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
  </style>
</head>

<body>

<div class="container mt-4">

  <!-- HEADER -->
  <div class="header d-flex justify-content-between align-items-center">
    <h4 class="m-0">📡 Detalle del Sensor</h4>

    <a href="<?= base_url('sensores') ?>" class="btn-volver">
      ⬅ Volver
    </a>
  </div>

  <!-- CARD SENSOR -->
  <div class="card-sensor">

    <h3>Sensor #<?= $sensor['id'] ?></h3>

    <hr>

    <p><strong>📍 Sector:</strong> <?= $sensor['sector'] ?></p>

    <p>
      <strong>⚙ Funcionamiento:</strong>
      <span class="estado <?= $sensor['funcionamiento'] ?>">
        <?= ucfirst($sensor['funcionamiento']) ?>
      </span>
    </p>

  </div>

</div>

</body>
</html>