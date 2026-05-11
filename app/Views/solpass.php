<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Solicitudes</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        max-width: 900px;
        margin: 0 auto;
        padding: 40px 28px 70px;
    }

    /* ── HEADER ── */
    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 32px;
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
        font-family: 'Syne', sans-serif; font-size: 26px; font-weight: 800;
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

    /* ── MAIN CARD ── */
    .main-card {
        background: var(--bg-card);
        backdrop-filter: blur(28px); -webkit-backdrop-filter: blur(28px);
        border: 1px solid var(--border);
        border-radius: 22px; overflow: hidden;
        box-shadow: 0 60px 120px rgba(0,0,0,0.6), inset 0 1px 0 rgba(56,189,248,0.08);
        animation: fade-up 0.7s ease 0.1s both;
    }

    .card-header-bar {
        padding: 20px 28px;
        border-bottom: 1px solid var(--border-s);
        display: flex; align-items: center; justify-content: space-between;
        background: linear-gradient(to right, rgba(56,189,248,0.03), transparent);
        position: relative;
    }
    .card-header-bar::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
        background: linear-gradient(90deg, var(--blue), transparent);
    }

    .card-title {
        font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700;
        color: var(--text); display: flex; align-items: center; gap: 10px;
    }
    .card-title i { color: var(--blue); font-size: 14px; }

    .count-badge {
        font-size: 11px; padding: 4px 14px; border-radius: 100px;
        background: rgba(56,189,248,0.08); border: 1px solid rgba(56,189,248,0.18);
        color: var(--blue);
    }

    /* ── TABLA ── */
    .glass-table { width: 100%; border-collapse: collapse; font-size: 14px; }

    .glass-table thead th {
        font-family: 'Syne', sans-serif; font-size: 10px;
        letter-spacing: 0.1em; text-transform: uppercase;
        color: var(--muted); font-weight: 600;
        padding: 14px 24px;
        border-bottom: 1px solid var(--border-s);
        background: rgba(56,189,248,0.02);
    }

    .glass-table tbody td {
        padding: 15px 24px;
        border-bottom: 1px solid var(--border-s);
        color: var(--text); vertical-align: middle;
    }

    .glass-table tbody tr:last-child td { border-bottom: none; }
    .glass-table tbody tr { transition: background 0.15s ease; animation: fade-up 0.4s ease both; }
    .glass-table tbody tr:hover { background: rgba(56,189,248,0.025); }

    .glass-table tbody tr:nth-child(1) { animation-delay: 0.2s; }
    .glass-table tbody tr:nth-child(2) { animation-delay: 0.27s; }
    .glass-table tbody tr:nth-child(3) { animation-delay: 0.34s; }
    .glass-table tbody tr:nth-child(4) { animation-delay: 0.41s; }
    .glass-table tbody tr:nth-child(5) { animation-delay: 0.48s; }

    .row-id {
        font-family: 'Syne', sans-serif; font-size: 12px;
        color: var(--muted); letter-spacing: 0.04em;
    }

    /* BADGES ESTADO */
    .badge-estado {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 11px; padding: 5px 14px; border-radius: 100px; font-weight: 500;
    }
    .badge-pendiente  { background: rgba(250,204,21,0.1);  border: 1px solid rgba(250,204,21,0.25);  color: #fde047; }
    .badge-aprobado   { background: rgba(34,197,94,0.1);   border: 1px solid rgba(34,197,94,0.25);   color: #4ade80; }
    .badge-rechazado  { background: rgba(239,68,68,0.1);   border: 1px solid rgba(239,68,68,0.25);   color: #f87171; }
    .badge-sin-estado { background: rgba(100,116,139,0.1); border: 1px solid rgba(100,116,139,0.2);  color: var(--muted); }

    /* BOTONES ACCIÓN */
    .btn-aprobar {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 14px; border-radius: 9px; font-size: 12px; font-weight: 500;
        background: rgba(34,197,94,0.12); border: 1px solid rgba(34,197,94,0.28); color: #4ade80;
        text-decoration: none; transition: all 0.18s ease; margin-right: 6px;
    }
    .btn-aprobar:hover { background: rgba(34,197,94,0.22); color: #4ade80; transform: translateY(-1px); }

    .btn-rechazar {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 14px; border-radius: 9px; font-size: 12px; font-weight: 500;
        background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.28); color: #f87171;
        text-decoration: none; transition: all 0.18s ease;
    }
    .btn-rechazar:hover { background: rgba(239,68,68,0.22); color: #f87171; transform: translateY(-1px); }

    /* EMPTY STATE */
    .empty-state {
        padding: 52px 28px;
        display: flex; flex-direction: column; align-items: center; gap: 14px; color: var(--muted);
    }
    .empty-icon {
        width: 52px; height: 52px; border-radius: 14px;
        background: rgba(251,191,36,0.06); border: 1px solid rgba(251,191,36,0.15);
        display: flex; align-items: center; justify-content: center;
        font-size: 20px; color: #facc15;
    }
    .empty-text { font-size: 14px; color: var(--muted); }

    /* ── ANIM ── */
    @keyframes fade-up {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 600px) {
        .page-wrap { padding: 24px 16px 50px; }
        .glass-table thead th,
        .glass-table tbody td { padding: 12px 14px; }
        .header-title { font-size: 20px; }
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
                <div class="header-eyebrow">CO Monitor · Admin</div>
                <div class="header-title">Solicitudes</div>
            </div>
        </div>
        <a href="<?= base_url('vistaprincipal') ?>" class="btn-back">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <!-- MAIN CARD -->
    <div class="main-card">

        <div class="card-header-bar">
            <div class="card-title">
                <i class="fas fa-inbox"></i>
                Gestión de Solicitudes
            </div>
            <?php if(isset($solicitudes) && count($solicitudes) > 0): ?>
                <span class="count-badge"><?= count($solicitudes) ?> solicitudes</span>
            <?php endif; ?>
        </div>

        <?php if(isset($solicitudes) && count($solicitudes) > 0): ?>

        <div class="table-responsive">
        <table class="glass-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($solicitudes as $s): ?>

                <?php $estado = strtolower(trim($s['estado'])); ?>

                <tr>
                    <td><span class="row-id">#<?= str_pad($s['id'], 3, '0', STR_PAD_LEFT) ?></span></td>
                    <td><?= $s['email'] ?></td>

                    <td>
                        <?php if ($estado === 'pendiente'): ?>
                            <span class="badge-estado badge-pendiente">
                                <i class="fas fa-clock" style="font-size:9px;"></i> Pendiente
                            </span>
                        <?php elseif ($estado === 'aprobado'): ?>
                            <span class="badge-estado badge-aprobado">
                                <i class="fas fa-circle-check" style="font-size:9px;"></i> Aprobado
                            </span>
                        <?php elseif ($estado === 'rechazado'): ?>
                            <span class="badge-estado badge-rechazado">
                                <i class="fas fa-circle-xmark" style="font-size:9px;"></i> Rechazado
                            </span>
                        <?php else: ?>
                            <span class="badge-estado badge-sin-estado">
                                <i class="fas fa-minus" style="font-size:9px;"></i> Sin estado
                            </span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if(session()->get('rol') === 'admin' && $estado === 'pendiente'): ?>
                            <a href="<?= base_url('sp/aprobar/'.$s['id']) ?>" class="btn-aprobar">
                                <i class="fas fa-check" style="font-size:10px;"></i> Aprobar
                            </a>
                            <a href="<?= base_url('sp/rechazar/'.$s['id']) ?>" class="btn-rechazar">
                                <i class="fas fa-xmark" style="font-size:10px;"></i> Rechazar
                            </a>
                        <?php else: ?>
                            <span style="color:var(--muted);font-size:13px;">—</span>
                        <?php endif; ?>
                    </td>
                </tr>

            <?php endforeach; ?>
            </tbody>
        </table>
        </div>

        <?php else: ?>

        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-inbox"></i></div>
            <div class="empty-text">No hay solicitudes</div>
        </div>

        <?php endif; ?>

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