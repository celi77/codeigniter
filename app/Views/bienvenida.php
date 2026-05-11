<?php
// app/Views/vistabienvenida.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Detección de CO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue:    #38bdf8;
            --blue-dk: #0ea5e9;
            --blue-xdk:#0369a1;
            --bg-deep: #050814;
            --bg-mid:  #080f1e;
            --text:    #e2e8f0;
            --muted:   #64748b;
            --border:  rgba(56,189,248,0.18);
        }

        html, body {
            min-height: 100vh;
            overflow-x: hidden;
            background: var(--bg-deep);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
        }

        /* ── CANVAS FONDO ── */
        #bg-canvas {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        /* ── GRID OVERLAY ── */
        .grid-overlay {
            position: fixed;
            inset: 0;
            z-index: 1;
            background-image:
                linear-gradient(rgba(56,189,248,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(56,189,248,0.04) 1px, transparent 1px);
            background-size: 80px 80px;
            pointer-events: none;
        }

        /* ── NOISE TEXTURE ── */
        .noise {
            position: fixed;
            inset: 0;
            z-index: 2;
            opacity: 0.025;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
            pointer-events: none;
        }

        /* ── WRAPPER ── */
        .page-wrap {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: auto 1fr auto;
        }

        /* ── HEADER ── */
        .site-header {
            grid-column: 1 / -1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 28px 60px;
            border-bottom: 1px solid rgba(56,189,248,0.08);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(56,189,248,0.12);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            color: var(--blue);
        }

        .brand-name {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 16px;
            letter-spacing: 0.02em;
            color: var(--text);
        }

        .brand-sub {
            font-size: 11px;
            color: var(--muted);
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .header-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 100px;
            background: rgba(56,189,248,0.06);
            border: 1px solid rgba(56,189,248,0.15);
            font-size: 12px;
            color: var(--blue);
            letter-spacing: 0.04em;
        }

        .pulse-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #22c55e;
            box-shadow: 0 0 0 0 rgba(34,197,94,0.6);
            animation: pulse-ring 2s ease-out infinite;
        }

        @keyframes pulse-ring {
            0%   { box-shadow: 0 0 0 0 rgba(34,197,94,0.6); }
            70%  { box-shadow: 0 0 0 8px rgba(34,197,94,0); }
            100% { box-shadow: 0 0 0 0 rgba(34,197,94,0); }
        }

        /* ── HERO LEFT ── */
        .hero-left {
            grid-column: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 80px 60px 80px 60px;
            position: relative;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--blue);
            margin-bottom: 28px;
            opacity: 0;
            animation: slide-up 0.8s ease 0.2s forwards;
        }

        .eyebrow::before {
            content: '';
            display: block;
            width: 28px;
            height: 1px;
            background: var(--blue);
        }

        .hero-title {
            font-family: 'Syne', sans-serif;
            font-size: clamp(42px, 5vw, 68px);
            font-weight: 800;
            line-height: 1.05;
            letter-spacing: -0.025em;
            margin-bottom: 24px;
            opacity: 0;
            animation: slide-up 0.8s ease 0.35s forwards;
        }

        .hero-title .line-muted {
            color: var(--muted);
            display: block;
        }

        .hero-title .line-accent {
            background: linear-gradient(100deg, #e0f2fe 10%, var(--blue) 60%, #7dd3fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: block;
        }

        .hero-desc {
            font-size: 16px;
            line-height: 1.75;
            color: #94a3b8;
            max-width: 420px;
            margin-bottom: 48px;
            font-weight: 300;
            opacity: 0;
            animation: slide-up 0.8s ease 0.5s forwards;
        }

        /* ── BOTONES ── */
        .btn-row {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            opacity: 0;
            animation: slide-up 0.8s ease 0.65s forwards;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 28px;
            border-radius: 14px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            font-size: 15px;
            color: #fff;
            background: linear-gradient(135deg, var(--blue) 0%, var(--blue-dk) 100%);
            border: none;
            cursor: pointer;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 8px 32px rgba(14,165,233,0.28), 0 1px 0 rgba(255,255,255,0.15) inset;
        }

        .btn-primary::after {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 60%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.5s ease;
        }

        .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 18px 44px rgba(14,165,233,0.42), 0 1px 0 rgba(255,255,255,0.15) inset; color: #fff; }
        .btn-primary:hover::after { left: 140%; }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 28px;
            border-radius: 14px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
            font-size: 15px;
            color: #94a3b8;
            background: transparent;
            border: 1px solid rgba(148,163,184,0.2);
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-ghost:hover { color: var(--text); border-color: rgba(148,163,184,0.4); background: rgba(148,163,184,0.06); transform: translateY(-2px); }

        /* ── FEATURES INLINE ── */
        .features-list {
            margin-top: 52px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            opacity: 0;
            animation: slide-up 0.8s ease 0.8s forwards;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .feature-icon {
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(56,189,248,0.08);
            border: 1px solid rgba(56,189,248,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: var(--blue);
        }

        .feature-text strong {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--text);
        }

        .feature-text span {
            font-size: 12px;
            color: var(--muted);
        }

        /* ── HERO RIGHT ── */
        .hero-right {
            grid-column: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 60px 60px 20px;
            position: relative;
        }

        /* ── DASHBOARD CARD ── */
        .dashboard-card {
            width: 100%;
            max-width: 440px;
            background: rgba(10, 16, 34, 0.85);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(56,189,248,0.2);
            border-radius: 24px;
            overflow: hidden;
            box-shadow:
                0 0 0 1px rgba(56,189,248,0.04),
                0 60px 120px rgba(0,0,0,0.7),
                inset 0 1px 0 rgba(56,189,248,0.12);
            opacity: 0;
            animation: scale-in 1s cubic-bezier(0.16,1,0.3,1) 0.4s forwards;
        }

        @keyframes scale-in {
            from { opacity: 0; transform: scale(0.92) translateY(20px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }

        .card-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px;
            border-bottom: 1px solid rgba(56,189,248,0.1);
        }

        .topbar-dots { display: flex; gap: 7px; }
        .topbar-dots span {
            width: 11px; height: 11px; border-radius: 50%;
        }
        .dot-r { background: #ff5f57; }
        .dot-y { background: #febc2e; }
        .dot-g { background: #28c840; }

        .topbar-title {
            font-family: 'Syne', sans-serif;
            font-size: 12px;
            font-weight: 600;
            color: var(--muted);
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .topbar-live {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            color: #22c55e;
            font-weight: 500;
        }

        /* ── MEDIDOR CIRCULAR ── */
        .gauge-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 36px 24px 24px;
            position: relative;
        }

        .gauge-svg { width: 200px; height: 200px; }

        .gauge-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -30%);
            text-align: center;
        }

        .gauge-value {
            font-family: 'Syne', sans-serif;
            font-size: 46px;
            font-weight: 800;
            color: var(--blue);
            line-height: 1;
            display: block;
        }

        .gauge-unit {
            font-size: 13px;
            color: var(--muted);
            display: block;
            margin-top: 4px;
        }

        .gauge-status {
            margin-top: 16px;
            padding: 6px 18px;
            border-radius: 100px;
            background: rgba(34,197,94,0.1);
            border: 1px solid rgba(34,197,94,0.25);
            font-size: 12px;
            font-weight: 500;
            color: #4ade80;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        /* ── STATS GRID ── */
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 0;
            border-top: 1px solid rgba(56,189,248,0.1);
        }

        .stat-cell {
            padding: 18px 16px;
            text-align: center;
            border-right: 1px solid rgba(56,189,248,0.08);
        }

        .stat-cell:last-child { border-right: none; }

        .stat-val {
            font-family: 'Syne', sans-serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--text);
            display: block;
        }

        .stat-val.ok    { color: #4ade80; }
        .stat-val.warn  { color: #fbbf24; }
        .stat-val.blue  { color: var(--blue); }

        .stat-lbl {
            font-size: 10px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            display: block;
            margin-top: 4px;
        }

        /* ── MINI CHART ── */
        .chart-section {
            padding: 20px 22px 24px;
            border-top: 1px solid rgba(56,189,248,0.1);
        }

        .chart-label {
            font-size: 11px;
            color: var(--muted);
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        .chart-bars {
            display: flex;
            align-items: flex-end;
            gap: 5px;
            height: 60px;
        }

        .bar {
            flex: 1;
            border-radius: 4px 4px 0 0;
            background: rgba(56,189,248,0.15);
            border-top: 1px solid rgba(56,189,248,0.3);
            animation: grow-bar 1s cubic-bezier(0.16,1,0.3,1) forwards;
            transform-origin: bottom;
            transform: scaleY(0);
        }

        .bar.hi { background: rgba(56,189,248,0.35); border-top-color: var(--blue); }

        @keyframes grow-bar {
            to { transform: scaleY(1); }
        }

        /* ── SENSOR TAG ── */
        .sensor-row {
            padding: 14px 22px;
            border-top: 1px solid rgba(56,189,248,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sensor-id {
            font-family: 'Syne', sans-serif;
            font-size: 12px;
            color: var(--muted);
            letter-spacing: 0.06em;
        }

        .sensor-tag {
            font-size: 11px;
            padding: 4px 12px;
            border-radius: 100px;
            background: rgba(56,189,248,0.08);
            border: 1px solid rgba(56,189,248,0.2);
            color: var(--blue);
        }

        /* ── FOOTER ── */
        .site-footer {
            grid-column: 1 / -1;
            padding: 24px 60px;
            border-top: 1px solid rgba(56,189,248,0.07);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .footer-copy { font-size: 12px; color: var(--muted); }

        .footer-links { display: flex; gap: 24px; }
        .footer-links a { font-size: 12px; color: var(--muted); text-decoration: none; transition: color 0.2s; }
        .footer-links a:hover { color: var(--blue); }

        /* ── DECO LINE ── */
        .deco-line {
            position: absolute;
            top: 50%;
            left: 0;
            width: 1px;
            height: 60%;
            transform: translateY(-50%);
            background: linear-gradient(to bottom, transparent, rgba(56,189,248,0.3), transparent);
        }

        /* ── ANIMATIONS ── */
        @keyframes slide-up {
            from { opacity: 0; transform: translateY(22px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .page-wrap { grid-template-columns: 1fr; }
            .site-header { padding: 22px 28px; }
            .hero-left { padding: 52px 28px; }
            .hero-right { grid-column: 1; padding: 0 28px 52px; }
            .site-footer { padding: 20px 28px; flex-direction: column; gap: 12px; text-align: center; }
            .deco-line { display: none; }
        }
    </style>
</head>
<body>

<!-- Fondo animado con canvas -->
<canvas id="bg-canvas"></canvas>
<div class="grid-overlay"></div>
<div class="noise"></div>

<div class="page-wrap">

    <!-- HEADER -->
    <header class="site-header">
        <div class="brand">
            <div class="brand-icon">
                <i class="fas fa-cloud-sun"></i>
            </div>
            <div>
                <div class="brand-name">CO Monitor</div>
                <div class="brand-sub">Sistema de Detección</div>
            </div>
        </div>

        <div class="header-badge">
            <div class="pulse-dot"></div>
            Sistema activo
        </div>
    </header>

    <!-- HERO IZQUIERDA -->
    <section class="hero-left">
        <div class="deco-line"></div>

        <div class="eyebrow">
            <i class="fas fa-shield-alt" style="font-size:10px;"></i>
            Seguridad industrial
        </div>

        <h1 class="hero-title">

            <span class="line-accent">ALERTA</span>
            <span class="line-muted">CO</span>
        </h1>

        <p class="hero-desc">
           Detección inteligente de CO. Monitoreo en tiempo real, alertas automáticas y análisis avanzado para proteger tu entorno.
        </p>

        <div class="btn-row">
            <a href="<?= base_url('registro') ?>" class="btn-primary">
                <i class="fas fa-user-plus"></i>
                Crear cuenta
            </a>
            <a href="<?= site_url('login') ?>" class="btn-ghost">
                <i class="fas fa-arrow-right-to-bracket"></i>
                Iniciar sesión
            </a>
        </div>

        <div class="features-list">
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-bolt"></i></div>
                <div class="feature-text">
                    <strong>Monitoreo en tiempo real</strong>
                    <span>Actualización cada 500ms desde sensores IoT</span>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-bell"></i></div>
                <div class="feature-text">
                    <strong>Alertas automáticas</strong>
                    <span>Notificaciones ante niveles críticos de CO</span>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-chart-area"></i></div>
                <div class="feature-text">
                    <strong>Análisis y reportes</strong>
                    <span>Historial, tendencias y exportación de datos</span>
                </div>
            </div>
        </div>
    </section>

    <!-- HERO DERECHA: Dashboard Preview -->
    <section class="hero-right">
        <div class="dashboard-card">

            <!-- Barra superior tipo OS -->
            <div class="card-topbar">
                <div class="topbar-dots">
                    <span class="dot-r"></span>
                    <span class="dot-y"></span>
                    <span class="dot-g"></span>
                </div>
                <div class="topbar-title">Panel de Control</div>
                <div class="topbar-live">
                    <div class="pulse-dot"></div>
                    EN VIVO
                </div>
            </div>

            <!-- Medidor principal -->
            <div class="gauge-wrap">
                <svg class="gauge-svg" viewBox="0 0 200 200">
                    <!-- Pista -->
                    <circle cx="100" cy="100" r="74" fill="none"
                        stroke="rgba(56,189,248,0.08)" stroke-width="14"
                        stroke-dasharray="390" stroke-dashoffset="97"
                        stroke-linecap="round"
                        transform="rotate(135 100 100)"/>
                    <!-- Progreso -->
                    <circle cx="100" cy="100" r="74" fill="none"
                        stroke="url(#gaugeGrad)" stroke-width="14"
                        stroke-dasharray="390" stroke-dashoffset="312"
                        stroke-linecap="round"
                        transform="rotate(135 100 100)"
                        style="animation: dash-anim 1.8s ease 0.8s forwards; stroke-dashoffset: 312;">
                    </circle>
                    <!-- Marcas -->
                    <circle cx="100" cy="30" r="3" fill="rgba(56,189,248,0.4)"/>
                    <circle cx="170" cy="100" r="3" fill="rgba(56,189,248,0.25)"/>
                    <circle cx="30" cy="100" r="3" fill="rgba(56,189,248,0.25)"/>
                    <defs>
                        <linearGradient id="gaugeGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="#22c55e"/>
                            <stop offset="60%" stop-color="#38bdf8"/>
                            <stop offset="100%" stop-color="#0ea5e9"/>
                        </linearGradient>
                    </defs>
                </svg>

                <div class="gauge-center">
                    <span class="gauge-value" id="gauge-num">24</span>
                    <span class="gauge-unit">ppm CO</span>
                </div>

                <div class="gauge-status">
                    <div class="pulse-dot"></div>
                    Nivel seguro
                </div>
            </div>

            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-cell">
                    <span class="stat-val ok">98.6%</span>
                    <span class="stat-lbl">Uptime</span>
                </div>
                <div class="stat-cell">
                    <span class="stat-val blue" id="sensors-count">12</span>
                    <span class="stat-lbl">Sensores</span>
                </div>
                <div class="stat-cell">
                    <span class="stat-val warn">3</span>
                    <span class="stat-lbl">Alertas hoy</span>
                </div>
            </div>

            <!-- Mini gráfica de barras -->
            <div class="chart-section">
                <div class="chart-label">Últimas 12 horas — ppm CO</div>
                <div class="chart-bars" id="bars-container">
                    <!-- generado por JS -->
                </div>
            </div>

            <!-- Sensor ID -->
            <div class="sensor-row">
                <span class="sensor-id">Sensor #SN-0421 · Zona A</span>
                <span class="sensor-tag">Online</span>
            </div>

        </div>
    </section>

    <!-- FOOTER -->
    <footer class="site-footer">
        <span class="footer-copy">© <?= date('Y') ?> CO Monitor — Sistema de Detección de Monóxido de Carbono</span>
        <nav class="footer-links">
            <a href="#">Documentación</a>
            <a href="#">Soporte</a>
            <a href="#">Privacidad</a>
        </nav>
    </footer>

</div>

<style>
@keyframes dash-anim {
    to { stroke-dashoffset: 215; }
}
</style>

<script>
/* ── PARTÍCULAS EN CANVAS ── */
const canvas = document.getElementById('bg-canvas');
const ctx = canvas.getContext('2d');
let W, H, particles = [];

function resize() {
    W = canvas.width  = window.innerWidth;
    H = canvas.height = window.innerHeight;
}

class Particle {
    constructor() { this.reset(); }
    reset() {
        this.x  = Math.random() * W;
        this.y  = Math.random() * H;
        this.r  = Math.random() * 1.4 + 0.3;
        this.vx = (Math.random() - 0.5) * 0.25;
        this.vy = (Math.random() - 0.5) * 0.25;
        this.a  = Math.random() * 0.45 + 0.05;
    }
    update() {
        this.x += this.vx;
        this.y += this.vy;
        if (this.x < 0 || this.x > W || this.y < 0 || this.y > H) this.reset();
    }
    draw() {
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(56,189,248,${this.a})`;
        ctx.fill();
    }
}

function initParticles(n) {
    particles = Array.from({length: n}, () => new Particle());
}

/* Conexiones entre partículas cercanas */
function drawConnections() {
    const dist = 120;
    for (let i = 0; i < particles.length; i++) {
        for (let j = i + 1; j < particles.length; j++) {
            const dx = particles[i].x - particles[j].x;
            const dy = particles[i].y - particles[j].y;
            const d  = Math.sqrt(dx*dx + dy*dy);
            if (d < dist) {
                const alpha = (1 - d/dist) * 0.12;
                ctx.beginPath();
                ctx.moveTo(particles[i].x, particles[i].y);
                ctx.lineTo(particles[j].x, particles[j].y);
                ctx.strokeStyle = `rgba(56,189,248,${alpha})`;
                ctx.lineWidth = 0.5;
                ctx.stroke();
            }
        }
    }
}

/* Glow orbs grandes */
function drawOrbs() {
    const orbs = [
        { x: W * 0.15, y: H * 0.25, r: 340, c: 'rgba(14,165,233,0.06)' },
        { x: W * 0.75, y: H * 0.65, r: 260, c: 'rgba(56,189,248,0.05)' },
        { x: W * 0.5,  y: H * 1.0,  r: 300, c: 'rgba(3,105,161,0.07)' },
    ];
    orbs.forEach(o => {
        const g = ctx.createRadialGradient(o.x, o.y, 0, o.x, o.y, o.r);
        g.addColorStop(0, o.c);
        g.addColorStop(1, 'transparent');
        ctx.fillStyle = g;
        ctx.beginPath();
        ctx.arc(o.x, o.y, o.r, 0, Math.PI*2);
        ctx.fill();
    });
}

function loop() {
    ctx.clearRect(0, 0, W, H);
    drawOrbs();
    drawConnections();
    particles.forEach(p => { p.update(); p.draw(); });
    requestAnimationFrame(loop);
}

resize();
initParticles(70);
loop();
window.addEventListener('resize', () => { resize(); initParticles(70); });

/* ── BARRAS DEL GRÁFICO ── */
const heights = [22, 35, 28, 45, 38, 55, 42, 60, 48, 38, 52, 40];
const maxH = Math.max(...heights);
const container = document.getElementById('bars-container');
const hiIdx = heights.indexOf(maxH);

heights.forEach((h, i) => {
    const bar = document.createElement('div');
    bar.className = 'bar' + (i === hiIdx ? ' hi' : '');
    const pct = (h / maxH) * 100;
    bar.style.height = pct + '%';
    bar.style.animationDelay = (i * 0.06 + 1) + 's';
    container.appendChild(bar);
});

/* ── CONTADOR ANIMADO gauge ── */
function animateCount(el, target, duration) {
    const start = performance.now();
    function frame(now) {
        const t = Math.min((now - start) / duration, 1);
        el.textContent = Math.round(t * target);
        if (t < 1) requestAnimationFrame(frame);
    }
    requestAnimationFrame(frame);
}

setTimeout(() => {
    animateCount(document.getElementById('gauge-num'), 24, 1800);
    animateCount(document.getElementById('sensors-count'), 12, 1200);
}, 800);
</script>

</body>
</html>