<!-- app/Views/estadisticas.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadísticas - Sistema de Detección de CO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a 0%, #1e2937 100%);
            font-family: 'Inter', sans-serif;
            color: white;
            padding: 40px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        h1 {
            font-size: 32px;
            font-weight: 700;
            background: linear-gradient(90deg, #e0f2fe, #bae6fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-back {
            background: rgba(148, 163, 184, 0.2);
            color: #94a3b8;
            border: 1px solid rgba(148,163,184,0.4);
            padding: 10px 16px;
            border-radius: 12px;
            font-size: 14px;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-back:hover {
            background: rgba(148,163,184,0.3);
            color: white;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
            margin-bottom: 50px;
        }

        .card {
            background: rgba(15, 23, 42, 0.95);
            border-radius: 24px;
            padding: 30px;
            border: 1px solid rgba(56,189,248,0.2);
            box-shadow: 0 20px 50px -15px rgba(0,0,0,0.6);
            transition: 0.4s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 60px -15px rgba(14,165,233,0.4);
        }

        .card h2 {
            font-size: 18px;
            color: #94a3b8;
            margin-bottom: 15px;
        }

        .value {
            font-size: 40px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .normal { color: #22c55e; }
        .warning { color: #facc15; }
        .danger { color: #ef4444; }

        .info {
            font-size: 14px;
            color: #94a3b8;
        }

        .chart-container {
            background: rgba(15, 23, 42, 0.95);
            padding: 40px;
            border-radius: 24px;
            border: 1px solid rgba(56,189,248,0.2);
            box-shadow: 0 20px 50px -15px rgba(0,0,0,0.6);
            text-align: center;
        }

        canvas {
            max-width: 600px;
            margin: auto;
        }

    </style>
</head>
<body>

<div class="container">

    <div class="header">
        <h1>Estadísticas de Sensores</h1>
        <a href="<?= base_url('vistaprincipal') ?>" class="btn-back">← Volver</a>
    </div>

    <?php
        // Valores simulados
        $sensor1 = 35;
        $sensor2 = 78;
        $sensor3 = 120;
        $total = $sensor1 + $sensor2 + $sensor3;
    ?>

    <div class="cards">

        <div class="card">
            <h2>Sensor Cocina</h2>
            <div class="value normal"><?= $sensor1 ?> ppm</div>
            <div class="info">Nivel actual de CO</div>
        </div>

        <div class="card">
            <h2>Sensor Garaje</h2>
            <div class="value warning"><?= $sensor2 ?> ppm</div>
            <div class="info">Nivel moderado</div>
        </div>

        <div class="card">
            <h2>Sensor Dormitorio</h2>
            <div class="value danger"><?= $sensor3 ?> ppm</div>
            <div class="info">Nivel crítico</div>
        </div>

    </div>

    <!-- GRÁFICO GRANDE -->
    <div class="chart-container">
        <h2 style="margin-bottom:30px; color:#94a3b8;">Distribución Porcentual de CO</h2>
        <canvas id="graficoSensores"></canvas>
    </div>

</div>

<script>
    const ctx = document.getElementById('graficoSensores');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Cocina', 'Garaje', 'Dormitorio'],
            datasets: [{
                data: [
                    <?= ($sensor1/$total)*100 ?>,
                    <?= ($sensor2/$total)*100 ?>,
                    <?= ($sensor3/$total)*100 ?>
                ],
                backgroundColor: [
                    '#22c55e',
                    '#facc15',
                    '#ef4444'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: 'white',
                        font: {
                            size: 14
                        }
                    }
                }
            }
        }
    });
</script>

</body>
</html>