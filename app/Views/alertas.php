<?php

$critico = false;
$alertas = [];

foreach($sensores as $sensor){

    $ppm = $sensor['valor_ppm'];

    if($ppm >= 150){
        $critico = true;

        $alertas[] = [
            'critical',
            'ALERTA CRÍTICA: ' . ucfirst($sensor['sector']) . ' detectó ' . $ppm . ' ppm',
            'fa-circle-exclamation'
        ];

    } elseif($ppm >= 50){

        $alertas[] = [
            'warning',
            'Advertencia: ' . ucfirst($sensor['sector']) . ' tiene ' . $ppm . ' ppm',
            'fa-triangle-exclamation'
        ];

    } else {

        $alertas[] = [
            'normal',
            ucfirst($sensor['sector']) . ' sin riesgos (' . $ppm . ' ppm)',
            'fa-circle-check'
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Alertas - Sistema CO</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

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
        max-width: 1100px;
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

    .header-eyebrow { font-size: 10px; letter-spacing: 0.12em; text-transform: uppercase; color: var(--muted); margin-bottom: 3px; }

    .header-title {
        font-family: 'Syne', sans-serif; font-size: 28px; font-weight: 800;
        background: linear-gradient(100deg, #e0f2fe 10%, var(--blue) 70%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    }

    .btn-back {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 20px; border-radius: 12px;
        background: transparent; border: 1px solid rgba(148,163,184,0.18);
        color: var(--muted); font-size: 13px; font-family: 'DM Sans', sans-serif;
        text-decoration: none; transition: all 0.18s ease;
    }
    .btn-back:hover { color: var(--text); border-color: rgba(148,163,184,0.35); background: rgba(148,163,184,0.06); }

    /* ── ZONA CARDS ── */
    .zones-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 18px;
        margin-bottom: 24px;
    }

    .zone-card {
        background: var(--bg-card);
        backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px);
        border: 1px solid var(--border-s);
        border-radius: 20px;
        padding: 26px 24px;
        position: relative; overflow: hidden;
        transition: transform 0.22s ease, border-color 0.22s ease, box-shadow 0.22s ease;
        animation: fade-up 0.55s ease both;
    }

    .zone-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 24px 50px rgba(0,0,0,0.5);
    }

    /* barra lateral de acento */
    .zone-card::before {
        content: ''; position: absolute;
        top: 0; left: 0; bottom: 0; width: 3px;
        border-radius: 20px 0 0 20px;
    }
    .card-normal::before   { background: linear-gradient(to bottom, #22c55e, #16a34a); }
    .card-warning::before  { background: linear-gradient(to bottom, #facc15, #d97706); }
    .card-critical::before { background: linear-gradient(to bottom, #ef4444, #dc2626); }

    .card-normal:hover   { border-color: rgba(34,197,94,0.25); }
    .card-warning:hover  { border-color: rgba(250,204,21,0.25); }
    .card-critical:hover { border-color: rgba(239,68,68,0.25); }

    .zone-label {
        font-size: 10px; letter-spacing: 0.1em; text-transform: uppercase;
        color: var(--muted); margin-bottom: 16px;
        display: flex; align-items: center; gap: 8px;
    }

    .zone-icon {
        width: 34px; height: 34px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center; font-size: 14px;
        margin-bottom: 16px;
    }
    .card-normal   .zone-icon { background: rgba(34,197,94,0.1);  color: #22c55e; }
    .card-warning  .zone-icon { background: rgba(250,204,21,0.1); color: #facc15; }
    .card-critical .zone-icon { background: rgba(239,68,68,0.1);  color: #ef4444; }

    .zone-name {
        font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700;
        color: var(--text); margin-bottom: 14px;
    }

    .zone-ppm {
        font-family: 'Syne', sans-serif; font-size: 44px; font-weight: 800;
        line-height: 1; margin-bottom: 4px;
    }
    .zone-ppm .unit { font-size: 16px; font-weight: 400; color: var(--muted); margin-left: 4px; }

    .card-normal   .zone-ppm { color: #4ade80; }
    .card-warning  .zone-ppm { color: #fde047; }
    .card-critical .zone-ppm { color: #f87171; }

    .zone-estado {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 12px; padding: 5px 14px; border-radius: 100px;
        font-weight: 500; margin-top: 10px;
    }
    .card-normal   .zone-estado { background: rgba(34,197,94,0.1);  border: 1px solid rgba(34,197,94,0.25);  color: #4ade80; }
    .card-warning  .zone-estado { background: rgba(250,204,21,0.1); border: 1px solid rgba(250,204,21,0.25); color: #fde047; }
    .card-critical .zone-estado { background: rgba(239,68,68,0.1);  border: 1px solid rgba(239,68,68,0.25);  color: #f87171; }

    /* animación pulso para crítico */
    .card-critical .zone-ppm { animation: pulse-val 2s ease-in-out infinite; }
    @keyframes pulse-val {
        0%,100% { opacity: 1; }
        50%      { opacity: 0.7; }
    }

    .zone-card:nth-child(1) { animation-delay: 0.08s; }
    .zone-card:nth-child(2) { animation-delay: 0.16s; }
    .zone-card:nth-child(3) { animation-delay: 0.24s; }

    /* ── ESTADO GENERAL ── */
    .general-card {
        background: var(--bg-card);
        backdrop-filter: blur(28px); -webkit-backdrop-filter: blur(28px);
        border-radius: 22px; overflow: hidden;
        border: 1px solid <?= $critico ? 'rgba(239,68,68,0.3)' : 'rgba(34,197,94,0.2)' ?>;
        box-shadow: 0 0 60px <?= $critico ? 'rgba(239,68,68,0.08)' : 'rgba(34,197,94,0.06)' ?>, 0 40px 80px rgba(0,0,0,0.5);
        margin-bottom: 24px;
        animation: fade-up 0.65s ease 0.3s both;
        position: relative; overflow: hidden;
    }

    .general-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
        background: <?= $critico
            ? 'linear-gradient(90deg, #ef4444, transparent)'
            : 'linear-gradient(90deg, #22c55e, transparent)' ?>;
    }

    .general-inner {
        padding: 36px 40px;
        display: flex; align-items: center; justify-content: space-between; gap: 24px;
        flex-wrap: wrap;
    }

    .general-left {}
    .general-eyebrow { font-size: 10px; letter-spacing: 0.12em; text-transform: uppercase; color: var(--muted); margin-bottom: 8px; }
    .general-label { font-family: 'Syne', sans-serif; font-size: 17px; font-weight: 700; color: var(--text); }

    .general-status {
        font-family: 'Syne', sans-serif; font-size: 22px; font-weight: 800;
        display: flex; align-items: center; gap: 14px;
        color: <?= $critico ? '#f87171' : '#4ade80' ?>;
    }

    .status-icon-big {
        width: 48px; height: 48px; border-radius: 14px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; font-size: 20px;
        background: <?= $critico ? 'rgba(239,68,68,0.12)' : 'rgba(34,197,94,0.1)' ?>;
        border: 1px solid <?= $critico ? 'rgba(239,68,68,0.3)' : 'rgba(34,197,94,0.25)' ?>;
        color: <?= $critico ? '#f87171' : '#4ade80' ?>;
    }

    /* ── LOG DE ALERTAS ── */
    .log-card {
        background: var(--bg-card);
        backdrop-filter: blur(28px); -webkit-backdrop-filter: blur(28px);
        border: 1px solid var(--border);
        border-radius: 22px; overflow: hidden;
        box-shadow: 0 40px 80px rgba(0,0,0,0.5), inset 0 1px 0 rgba(56,189,248,0.08);
        animation: fade-up 0.7s ease 0.4s both;
    }

    .log-header {
        padding: 20px 28px;
        border-bottom: 1px solid var(--border-s);
        display: flex; align-items: center; gap: 10px;
        background: linear-gradient(to right, rgba(56,189,248,0.03), transparent);
        position: relative;
    }
    .log-header::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
        background: linear-gradient(90deg, var(--blue), transparent);
    }

    .log-title {
        font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700;
        color: var(--text); display: flex; align-items: center; gap: 10px;
    }
    .log-title i { color: var(--blue); font-size: 14px; }

    .log-body { padding: 12px 0; }

    .log-item {
        display: flex; align-items: flex-start; gap: 14px;
        padding: 14px 28px;
        border-bottom: 1px solid var(--border-s);
        transition: background 0.15s ease;
        animation: fade-up 0.4s ease both;
    }
    .log-item:last-child { border-bottom: none; }
    .log-item:hover { background: rgba(56,189,248,0.025); }

    .log-item:nth-child(1) { animation-delay: 0.5s; }
    .log-item:nth-child(2) { animation-delay: 0.58s; }
    .log-item:nth-child(3) { animation-delay: 0.66s; }

    .log-icon {
        width: 34px; height: 34px; border-radius: 10px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; font-size: 14px;
        margin-top: 1px;
    }
    .log-icon.critical { background: rgba(239,68,68,0.1);  border: 1px solid rgba(239,68,68,0.2);  color: #f87171; }
    .log-icon.warning  { background: rgba(250,204,21,0.1); border: 1px solid rgba(250,204,21,0.2); color: #fde047; }
    .log-icon.normal   { background: rgba(34,197,94,0.1);  border: 1px solid rgba(34,197,94,0.2);  color: #4ade80; }

    .log-text { font-size: 14px; color: var(--text); line-height: 1.5; }
    .log-time { font-size: 11px; color: var(--muted); margin-top: 2px; }

    /* ── ANIM ── */
    @keyframes fade-up {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0);    }
    }

    @media (max-width: 600px) {
        .page-wrap { padding: 24px 16px 50px; }
        .general-inner { padding: 24px 20px; }
        .log-item { padding: 12px 20px; }
        .log-header { padding: 16px 20px; }
        .header-title { font-size: 22px; }
        .general-status { font-size: 16px; }
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
            <div>
                <div class="header-eyebrow">CO Monitor</div>
                <div class="header-title">Centro de Alertas</div>
            </div>
        </div>
        <a href="<?= base_url('vistaprincipal') ?>" class="btn-back">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <!-- ZONA CARDS -->
    <div class="zones-grid">

<?php foreach($sensores as $sensor): ?>

<?php
    $ppm = $sensor['valor_ppm'];

    if($ppm >= 150){
        $estado = ['Crítico', 'card-critical'];
    } elseif($ppm >= 50){
        $estado = ['Advertencia', 'card-warning'];
    } else {
        $estado = ['Normal', 'card-normal'];
    }
?>

<div class="zone-card <?= $estado[1] ?>">

    <div class="zone-icon">
        <i class="fas fa-microchip"></i>
    </div>

    <div class="zone-name">
        <?= ucfirst($sensor['sector']) ?>
    </div>

    <div class="zone-ppm">
        <?= $ppm ?>
        <span class="unit">ppm</span>
    </div>

    <div class="zone-estado">
        <i class="fas <?= $ppm >= 150 ? 'fa-circle-exclamation' : ($ppm >= 50 ? 'fa-triangle-exclamation' : 'fa-circle-check') ?>"></i>

        <?= $estado[0] ?>
    </div>

</div>

<?php endforeach; ?>

</div>
    </div>

    <!-- ESTADO GENERAL -->
    <div class="general-card">
        <div class="general-inner">
            <div class="general-left">
                <div class="general-eyebrow">Diagnóstico del sistema</div>
                <div class="general-label">Estado General</div>
            </div>
            <div class="general-status">
                <div class="status-icon-big">
                    <i class="fas <?= $critico ? 'fa-triangle-exclamation' : 'fa-shield-check' ?>"></i>
                </div>
                <?= $critico ? 'SISTEMA EN ALERTA' : 'SISTEMA OPERANDO NORMALMENTE' ?>
            </div>
        </div>
    </div>

    <!-- LOG DE ALERTAS -->
    <div class="log-card">
        <div class="log-header">
            <div class="log-title">
                <i class="fas fa-clock-rotate-left"></i>
                Registro de Eventos del Sistema
            </div>
        </div>
        <div class="log-body">
            <?php foreach($alertas as $i => $a): ?>
                <div class="log-item">
                    <div class="log-icon <?= $a[0] ?>">
                        <i class="fas <?= $a[2] ?>"></i>
                    </div>
                    <div>
                        <div class="log-text"><?= $a[1] ?></div>
                        <div class="log-time"><i class="fas fa-circle" style="font-size:5px;margin-right:5px;color:var(--muted);"></i>Hace un momento</div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>

<script>
const canvas = document.getElementById('bg-canvas');
const ctx    = canvas.getContext('2d');
let W, H, particles = [];

function resize() { W = canvas.width = window.innerWidth; H = canvas.height = window.innerHeight; }

class Particle {
    constructor() { this.reset(); }
    reset() {
        this.x = Math.random()*W; this.y = Math.random()*H;
        this.r = Math.random()*1.3+0.3;
        this.vx = (Math.random()-.5)*.22; this.vy = (Math.random()-.5)*.22;
        this.a = Math.random()*.4+.05;
    }
    update() {
        this.x+=this.vx; this.y+=this.vy;
        if(this.x<0||this.x>W||this.y<0||this.y>H) this.reset();
    }
    draw() {
        ctx.beginPath(); ctx.arc(this.x,this.y,this.r,0,Math.PI*2);
        ctx.fillStyle=`rgba(56,189,248,${this.a})`; ctx.fill();
    }
}

function drawConnections() {
    const dist=110;
    for(let i=0;i<particles.length;i++)
        for(let j=i+1;j<particles.length;j++){
            const d=Math.hypot(particles[i].x-particles[j].x,particles[i].y-particles[j].y);
            if(d<dist){
                ctx.beginPath();
                ctx.moveTo(particles[i].x,particles[i].y);
                ctx.lineTo(particles[j].x,particles[j].y);
                ctx.strokeStyle=`rgba(56,189,248,${(1-d/dist)*.1})`;
                ctx.lineWidth=.5; ctx.stroke();
            }
        }
}

function drawOrbs(){
    [{x:W*.1,y:H*.15,r:300,c:'rgba(14,165,233,0.055)'},
     {x:W*.88,y:H*.6,r:230,c:'rgba(56,189,248,0.045)'},
     {x:W*.5,y:H*.98,r:270,c:'rgba(3,105,161,0.06)'}
    ].forEach(o=>{
        const g=ctx.createRadialGradient(o.x,o.y,0,o.x,o.y,o.r);
        g.addColorStop(0,o.c); g.addColorStop(1,'transparent');
        ctx.fillStyle=g; ctx.beginPath(); ctx.arc(o.x,o.y,o.r,0,Math.PI*2); ctx.fill();
    });
}

function loop(){
    ctx.clearRect(0,0,W,H); drawOrbs(); drawConnections();
    particles.forEach(p=>{p.update();p.draw();}); requestAnimationFrame(loop);
}

resize(); particles=Array.from({length:55},()=>new Particle()); loop();
window.addEventListener('resize',()=>{resize();particles=Array.from({length:55},()=>new Particle());});
</script>
</body>
</html>