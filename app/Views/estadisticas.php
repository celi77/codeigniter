<!-- app/Views/estadisticas.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue:    #38bdf8;
            --blue-dk: #0ea5e9;
            --bg-deep: #050814;
            --bg-card: rgba(10, 16, 34, 0.85);
            --border:  rgba(56,189,248,0.15);
            --border-s:rgba(56,189,248,0.08);
            --text:    #e2e8f0;
            --muted:   #64748b;
        }

        html, body {
            min-height: 100vh;
            background: var(--bg-deep);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            overflow-x: hidden;
        }

        /* ── FONDO ── */
        #bg-canvas { position: fixed; inset: 0; z-index: 0; pointer-events: none; }
        .grid-overlay {
            position: fixed; inset: 0; z-index: 1; pointer-events: none;
            background-image:
                linear-gradient(rgba(56,189,248,0.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(56,189,248,0.035) 1px, transparent 1px);
            background-size: 72px 72px;
        }
        .noise {
            position: fixed; inset: 0; z-index: 2; opacity: 0.022; pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
        }

        /* ── PAGE ── */
        .page-wrap {
            position: relative; z-index: 10;
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 28px 70px;
        }

        /* ── HEADER ── */
        .page-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 40px;
            animation: fade-up 0.6s ease both;
        }

        .header-left { display: flex; align-items: center; gap: 16px; }

        .brand-icon {
            width: 44px; height: 44px; border-radius: 12px;
            background: rgba(56,189,248,0.1); border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; color: var(--blue);
        }

        .header-titles {}
        .header-eyebrow {
            font-size: 10px; letter-spacing: 0.12em; text-transform: uppercase;
            color: var(--muted); margin-bottom: 3px;
        }
        .header-title {
            font-family: 'Syne', sans-serif; font-size: 28px; font-weight: 800;
            background: linear-gradient(100deg, #e0f2fe 10%, var(--blue) 70%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-back {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 20px; border-radius: 12px;
            background: transparent; border: 1px solid rgba(148,163,184,0.18);
            color: var(--muted); font-size: 13px; font-family: 'DM Sans', sans-serif;
            text-decoration: none; transition: all 0.18s ease;
        }
        .btn-back:hover { color: var(--text); border-color: rgba(148,163,184,0.35); background: rgba(148,163,184,0.06); }

        /* ── SENSOR CARDS GRID ── */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 18px;
            margin-bottom: 32px;
        }

        .sensor-card {
            background: var(--bg-card);
            backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--border-s);
            border-radius: 20px;
            padding: 24px 22px;
            position: relative; overflow: hidden;
            transition: transform 0.22s ease, border-color 0.22s ease, box-shadow 0.22s ease;
            animation: fade-up 0.5s ease both;
        }

        .sensor-card:hover {
            transform: translateY(-4px);
            border-color: rgba(56,189,248,0.22);
            box-shadow: 0 24px 50px rgba(0,0,0,0.5);
        }

        /* barra de acento lateral */
        .sensor-card::before {
            content: ''; position: absolute;
            top: 0; left: 0; bottom: 0; width: 3px;
            border-radius: 20px 0 0 20px;
        }
        .card-normal::before   { background: linear-gradient(to bottom, #22c55e, #16a34a); }
        .card-warning::before  { background: linear-gradient(to bottom, #facc15, #d97706); }
        .card-danger::before   { background: linear-gradient(to bottom, #ef4444, #dc2626); }

        .card-sector {
            font-size: 10px; letter-spacing: 0.1em; text-transform: uppercase;
            color: var(--muted); margin-bottom: 14px;
            display: flex; align-items: center; gap: 8px;
        }
        .card-sector i { font-size: 10px; }

        .card-value {
            font-family: 'Syne', sans-serif; font-size: 42px; font-weight: 800;
            line-height: 1; margin-bottom: 8px;
        }
        .card-value.normal  { color: #4ade80; }
        .card-value.warning { color: #fde047; }
        .card-value.danger  { color: #f87171; }

        .card-unit {
            font-size: 14px; font-weight: 400; color: var(--muted); margin-left: 4px;
        }

        .card-status {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 12px; padding: 5px 12px; border-radius: 100px; font-weight: 500;
            margin-top: 4px;
        }
        .status-normal  { background: rgba(34,197,94,0.1);  border: 1px solid rgba(34,197,94,0.25);  color: #4ade80; }
        .status-warning { background: rgba(250,204,21,0.1); border: 1px solid rgba(250,204,21,0.25); color: #fde047; }
        .status-danger  { background: rgba(239,68,68,0.1);  border: 1px solid rgba(239,68,68,0.25);  color: #f87171; }

        /* stagger cards */
        .sensor-card:nth-child(1) { animation-delay: 0.08s; }
        .sensor-card:nth-child(2) { animation-delay: 0.14s; }
        .sensor-card:nth-child(3) { animation-delay: 0.20s; }
        .sensor-card:nth-child(4) { animation-delay: 0.26s; }
        .sensor-card:nth-child(5) { animation-delay: 0.32s; }
        .sensor-card:nth-child(6) { animation-delay: 0.38s; }
        .sensor-card:nth-child(7) { animation-delay: 0.44s; }
        .sensor-card:nth-child(8) { animation-delay: 0.50s; }

        /* ── CHART CARD ── */
        .chart-card {
            background: var(--bg-card);
            backdrop-filter: blur(28px); -webkit-backdrop-filter: blur(28px);
            border: 1px solid var(--border);
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 60px 120px rgba(0,0,0,0.5), inset 0 1px 0 rgba(56,189,248,0.08);
            animation: fade-up 0.7s ease 0.35s both;
        }

        .chart-header {
            padding: 22px 32px;
            border-bottom: 1px solid var(--border-s);
            display: flex; align-items: center; justify-content: space-between;
            background: linear-gradient(to right, rgba(56,189,248,0.03), transparent);
            position: relative;
        }

        .chart-header::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, var(--blue), transparent);
        }

        .chart-title {
            font-family: 'Syne', sans-serif; font-size: 16px; font-weight: 700;
            color: var(--text); display: flex; align-items: center; gap: 10px;
        }
        .chart-title i { color: var(--blue); font-size: 14px; }

        .chart-subtitle { font-size: 12px; color: var(--muted); margin-top: 2px; }

       

 .chart-body {
    padding: 20px 40px 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 520px;
}

canvas#graficoSensores {
    width: 100% !important;
    height: 480px !important;
    max-width: 700px;
}

        /* ── ANIM ── */
        @keyframes fade-up {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0);    }
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 600px) {
            .page-wrap { padding: 24px 16px 50px; }
            .chart-body { padding: 24px 16px; }
            .chart-header { padding: 16px 20px; }
            .header-title { font-size: 22px; }
        }
    </style>
</head>
<body>

<canvas id="bg-canvas"></canvas>
<div class="grid-overlay"></div>
<div class="noise"></div>

<div class="page-wrap">

    <!-- HEADER -->
    <div class="page-header">
        <div class="header-left">
            <div class="brand-icon"><i class="fas fa-cloud-sun"></i></div>
            <div class="header-titles">
                <div class="header-eyebrow">CO Monitor</div>
                <div class="header-title">Estadísticas de Sensores</div>
            </div>
        </div>
        <a href="<?= base_url('vistaprincipal') ?>" class="btn-back">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <!-- SENSOR CARDS -->
    <?php
    $total = 0;
    foreach ($sensores as $s) { $total += $s['valor_ppm']; }
    ?>

    <div class="cards-grid">
        <?php foreach ($sensores as $sensor): ?>
            <?php
                $valor = $sensor['valor_ppm'];
                if ($sensor['funcionamiento'] === 'apagado') {
                    $estado = 'warning'; $texto = 'Sensor apagado'; $icon = 'fa-power-off';
                } elseif ($valor < 50) {
                    $estado = 'normal';  $texto = 'Nivel normal';   $icon = 'fa-circle-check';
                } elseif ($valor < 100) {
                    $estado = 'warning'; $texto = 'Nivel moderado'; $icon = 'fa-triangle-exclamation';
                } else {
                    $estado = 'danger';  $texto = 'Nivel crítico';  $icon = 'fa-circle-exclamation';
                }
            ?>
            <div class="sensor-card card-<?= $estado ?>">
                <div class="card-sector">
                    <i class="fas fa-location-dot"></i>
                    <?= esc($sensor['sector']) ?>
                </div>
                <div class="card-value <?= $estado ?>">
                    <?= esc($valor) ?><span class="card-unit">ppm</span>
                </div>
                <div class="card-status status-<?= $estado ?>">
                    <i class="fas <?= $icon ?>" style="font-size:10px;"></i>
                    <?= $texto ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- GRÁFICO -->
    <div class="chart-card">
        <div class="chart-header">
            <div>
                <div class="chart-title">
                    <i class="fas fa-chart-pie"></i>
                    Distribución Porcentual de CO
                </div>
                <div class="chart-subtitle">Proporción de ppm por sector</div>
            </div>
        </div>
        <div class="chart-body">
            <canvas id="graficoSensores"></canvas>
        </div>
    </div>

</div>

<script>
/* ── PARTÍCULAS ── */
const bgCanvas = document.getElementById('bg-canvas');
const bgCtx    = bgCanvas.getContext('2d');
let W, H, particles = [];

function resize() { W = bgCanvas.width = window.innerWidth; H = bgCanvas.height = window.innerHeight; }

class Particle {
    constructor() { this.reset(); }
    reset() {
        this.x = Math.random()*W; this.y = Math.random()*H;
        this.r = Math.random()*1.3+0.3;
        this.vx = (Math.random()-.5)*.22; this.vy = (Math.random()-.5)*.22;
        this.a = Math.random()*.4+.05;
    }
    update() {
        this.x += this.vx; this.y += this.vy;
        if (this.x<0||this.x>W||this.y<0||this.y>H) this.reset();
    }
    draw() {
        bgCtx.beginPath(); bgCtx.arc(this.x, this.y, this.r, 0, Math.PI*2);
        bgCtx.fillStyle = `rgba(56,189,248,${this.a})`; bgCtx.fill();
    }
}

function drawConnections() {
    const dist = 110;
    for (let i=0;i<particles.length;i++)
        for (let j=i+1;j<particles.length;j++) {
            const d = Math.hypot(particles[i].x-particles[j].x, particles[i].y-particles[j].y);
            if (d < dist) {
                bgCtx.beginPath();
                bgCtx.moveTo(particles[i].x, particles[i].y);
                bgCtx.lineTo(particles[j].x, particles[j].y);
                bgCtx.strokeStyle = `rgba(56,189,248,${(1-d/dist)*.1})`;
                bgCtx.lineWidth = .5; bgCtx.stroke();
            }
        }
}

function drawOrbs() {
    [{x:W*.1,y:H*.15,r:300,c:'rgba(14,165,233,0.055)'},
     {x:W*.88,y:H*.6,r:230,c:'rgba(56,189,248,0.045)'},
     {x:W*.5,y:H*.98,r:270,c:'rgba(3,105,161,0.06)'}
    ].forEach(o => {
        const g = bgCtx.createRadialGradient(o.x,o.y,0,o.x,o.y,o.r);
        g.addColorStop(0,o.c); g.addColorStop(1,'transparent');
        bgCtx.fillStyle=g; bgCtx.beginPath(); bgCtx.arc(o.x,o.y,o.r,0,Math.PI*2); bgCtx.fill();
    });
}

function loop() {
    bgCtx.clearRect(0,0,W,H); drawOrbs(); drawConnections();
    particles.forEach(p=>{p.update();p.draw();}); requestAnimationFrame(loop);
}

resize(); particles = Array.from({length:55}, ()=>new Particle()); loop();
window.addEventListener('resize', ()=>{ resize(); particles = Array.from({length:55}, ()=>new Particle()); });

/* ── CHART ── */
document.addEventListener("DOMContentLoaded", function () {
    const canvas = document.getElementById('graficoSensores');
    if (!canvas) return;

    new Chart(canvas.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: [
                <?php foreach ($sensores as $s): ?>"<?= esc($s['sector']) ?>",<?php endforeach; ?>
            ],
            datasets: [{
                data: [
                    <?php foreach ($sensores as $s): ?>
                        <?= $total > 0 ? round(($s['valor_ppm'] / $total) * 100, 2) : 0 ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: ['#22c55e','#facc15','#ef4444','#38bdf8','#a78bfa','#fb923c','#34d399'],
                borderColor: 'rgba(10,16,34,0.8)',
                borderWidth: 3,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#94a3b8',
                        font: { family: 'DM Sans', size: 12 },
                        padding: 20,
                        usePointStyle: true,
                        pointStyleWidth: 8
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(10,16,34,0.95)',
                    borderColor: 'rgba(56,189,248,0.2)',
                    borderWidth: 1,
                    titleColor: '#e2e8f0',
                    bodyColor: '#94a3b8',
                    padding: 12,
                    callbacks: {
                        label: ctx => ` ${ctx.parsed.toFixed(1)}% del total`
                    }
                }
            }
        }
    });
});
</script>

</body>
</html>