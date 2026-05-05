<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña — CO Monitor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href__="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href__="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue:    #38bdf8;
            --blue-dk: #0ea5e9;
            --bg-deep: #050814;
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

        /* ── FONDO ── */
        #bg-canvas { position: fixed; inset: 0; z-index: 0; pointer-events: none; }

        .grid-overlay {
            position: fixed; inset: 0; z-index: 1; pointer-events: none;
            background-image:
                linear-gradient(rgba(56,189,248,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(56,189,248,0.04) 1px, transparent 1px);
            background-size: 80px 80px;
        }

        .noise {
            position: fixed; inset: 0; z-index: 2; opacity: 0.025; pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
        }

        /* ── LAYOUT ── */
        .page-wrap {
            position: relative; z-index: 10;
            min-height: 100vh;
            display: flex; flex-direction: column;
        }

        /* ── HEADER ── */
        .site-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 24px 56px;
            border-bottom: 1px solid rgba(56,189,248,0.08);
        }

        .brand { display: flex; align-items: center; gap: 12px; }

        .brand-icon {
            width: 36px; height: 36px; border-radius: 10px;
            background: rgba(56,189,248,0.1); border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; color: var(--blue);
        }

        .brand-name {
            font-family: 'Syne', sans-serif; font-weight: 700;
            font-size: 15px; letter-spacing: 0.02em;
        }

        .brand-sub {
            font-size: 10px; color: var(--muted);
            letter-spacing: 0.08em; text-transform: uppercase;
        }

        .header-badge {
            display: flex; align-items: center; gap: 7px;
            padding: 7px 14px; border-radius: 100px;
            background: rgba(56,189,248,0.06); border: 1px solid rgba(56,189,248,0.15);
            font-size: 11px; color: var(--blue); letter-spacing: 0.04em;
        }

        .pulse-dot {
            width: 7px; height: 7px; border-radius: 50%; background: #22c55e;
            animation: pulse-ring 2s ease-out infinite;
        }

        @keyframes pulse-ring {
            0%   { box-shadow: 0 0 0 0   rgba(34,197,94,0.6); }
            70%  { box-shadow: 0 0 0 8px rgba(34,197,94,0);   }
            100% { box-shadow: 0 0 0 0   rgba(34,197,94,0);   }
        }

        /* ── MAIN centrado ── */
        .main-content {
            flex: 1; display: flex;
            align-items: center; justify-content: center;
            padding: 48px 24px;
        }

        /* ── CARD ── */
        .recover-card {
            width: 100%; max-width: 480px;
            background: rgba(8,15,30,0.90);
            backdrop-filter: blur(32px); -webkit-backdrop-filter: blur(32px);
            border: 1px solid rgba(56,189,248,0.18); border-radius: 28px;
            padding: 48px 44px;
            box-shadow:
                0 0 0 1px rgba(56,189,248,0.04),
                0 50px 120px rgba(0,0,0,0.65),
                inset 0 1px 0 rgba(56,189,248,0.10);
            opacity: 0;
            animation: scale-in 0.9s cubic-bezier(0.16,1,0.3,1) forwards;
            position: relative; overflow: hidden;
        }

        /* Orb interior decorativo */
        .recover-card::before {
            content: ''; position: absolute;
            width: 280px; height: 280px; border-radius: 50%;
            background: radial-gradient(circle, rgba(56,189,248,0.07) 0%, transparent 70%);
            top: -80px; right: -80px; pointer-events: none;
        }

        @keyframes scale-in {
            from { opacity:0; transform: scale(0.95) translateY(16px); }
            to   { opacity:1; transform: scale(1)    translateY(0);    }
        }

        /* ── ICONO CENTRAL ── */
        .icon-wrap {
            width: 68px; height: 68px; border-radius: 18px;
            background: rgba(56,189,248,0.08);
            border: 1px solid rgba(56,189,248,0.22);
            display: flex; align-items: center; justify-content: center;
            font-size: 26px; color: var(--blue);
            margin: 0 auto 28px;
            box-shadow: 0 0 40px rgba(56,189,248,0.15);
            position: relative; z-index: 1;
        }

        /* ── TEXTOS ── */
        .eyebrow {
            display: flex; align-items: center; justify-content: center; gap: 7px;
            font-size: 10px; font-weight: 500; letter-spacing: 0.12em;
            text-transform: uppercase; color: var(--blue); margin-bottom: 12px;
            position: relative; z-index: 1;
        }

        .eyebrow::before, .eyebrow::after {
            content: ''; display: block; width: 18px; height: 1px; background: var(--blue);
        }

        .card-title {
            font-family: 'Syne', sans-serif;
            font-size: 28px; font-weight: 800;
            letter-spacing: -0.02em; text-align: center;
            line-height: 1.1; margin-bottom: 10px;
            position: relative; z-index: 1;
        }

        .card-title .muted  { color: var(--muted); display: block; }
        .card-title .accent {
            background: linear-gradient(100deg, #e0f2fe 10%, #38bdf8 60%, #7dd3fc);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text; display: block;
        }

        .card-desc {
            text-align: center; font-size: 13px; font-weight: 300;
            color: #94a3b8; line-height: 1.7; margin-bottom: 32px;
            position: relative; z-index: 1;
        }

        /* ── MENSAJES ── */
        .msg {
            display: flex; align-items: flex-start; gap: 10px;
            padding: 11px 14px; border-radius: 10px;
            font-size: 13px; margin-bottom: 20px;
            position: relative; z-index: 1;
        }

        .msg-ok {
            background: rgba(34,197,94,0.08); border: 1px solid rgba(34,197,94,0.25);
            border-left: 3px solid #22c55e; color: #4ade80;
        }

        .msg-error {
            background: rgba(248,113,113,0.08); border: 1px solid rgba(248,113,113,0.25);
            border-left: 3px solid #f87171; color: #fca5a5;
        }

        /* ── FORM ── */
        .form-group { margin-bottom: 20px; position: relative; z-index: 1; }

        label {
            display: block; font-size: 12px; font-weight: 500;
            color: rgba(226,232,240,0.65); letter-spacing: 0.01em;
            margin-bottom: 6px;
        }

        .input-wrap { position: relative; }

        .input-icon {
            position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
            font-size: 13px; color: var(--muted); pointer-events: none;
        }

        input[type="email"] {
            width: 100%;
            padding: 12px 16px 12px 36px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(148,163,184,0.15);
            border-radius: 11px;
            font-size: 13px; color: var(--text);
            font-family: 'DM Sans', sans-serif;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
            outline: none;
        }

        input::placeholder { color: rgba(100,116,139,0.7); }

        input:focus {
            border-color: var(--blue);
            background: rgba(56,189,248,0.06);
            box-shadow: 0 0 0 3px rgba(56,189,248,0.12);
        }

        /* ── STEPS INDICATOR ── */
        .steps {
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 28px; position: relative; z-index: 1;
        }

        .step {
            display: flex; align-items: center; gap: 6px;
            font-size: 11px; color: var(--muted);
        }

        .step.active { color: var(--blue); }

        .step-num {
            width: 20px; height: 20px; border-radius: 50%;
            border: 1px solid rgba(148,163,184,0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 10px; font-weight: 600; color: var(--muted);
        }

        .step.active .step-num {
            background: rgba(56,189,248,0.15); border-color: rgba(56,189,248,0.4);
            color: var(--blue);
        }

        .step-sep { flex: 1; height: 1px; background: rgba(148,163,184,0.12); }

        /* ── BOTÓN ── */
        .btn-submit {
            width: 100%; padding: 13px;
            background: linear-gradient(135deg, #38bdf8, #0ea5e9);
            color: #fff; border: none; border-radius: 12px;
            font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 500;
            cursor: pointer; position: relative; overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 8px 28px rgba(14,165,233,0.28), inset 0 1px 0 rgba(255,255,255,0.15);
            display: flex; align-items: center; justify-content: center; gap: 8px;
            z-index: 1;
        }

        .btn-submit::after {
            content: ''; position: absolute; top: 0; left: -100%;
            width: 60%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.5s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 40px rgba(14,165,233,0.4), inset 0 1px 0 rgba(255,255,255,0.15);
        }

        .btn-submit:hover::after { left: 140%; }

        /* ── FOOTER CARD ── */
        .card-footer {
            margin-top: 22px; text-align: center;
            font-size: 12px; color: var(--muted);
            position: relative; z-index: 1;
            display: flex; flex-direction: column; gap: 8px;
        }

        .card-footer a { color: var(--blue); text-decoration: none; font-weight: 500; }
        .card-footer a:hover { color: #7dd3fc; }

        .btn-back {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 12px; color: var(--muted);
            background: rgba(148,163,184,0.06); border: 1px solid rgba(148,163,184,0.15);
            padding: 7px 14px; border-radius: 10px; text-decoration: none;
            transition: all 0.2s ease; width: fit-content; margin: 0 auto;
        }

        .btn-back:hover { color: var(--text); background: rgba(148,163,184,0.10); border-color: rgba(148,163,184,0.28); }

        /* ── SITE FOOTER ── */
        .site-footer {
            padding: 18px 56px; border-top: 1px solid rgba(56,189,248,0.07);
            display: flex; align-items: center; justify-content: space-between;
            position: relative; z-index: 10;
        }

        .footer-copy { font-size: 11px; color: var(--muted); }
        .footer-links { display: flex; gap: 20px; }
        .footer-links a { font-size: 11px; color: var(--muted); text-decoration: none; transition: color 0.2s; }
        .footer-links a:hover { color: var(--blue); }

        /* ── RESPONSIVE ── */
        @media (max-width: 600px) {
            .site-header { padding: 20px 24px; }
            .recover-card { padding: 36px 24px; }
            .site-footer  { padding: 16px 24px; flex-direction: column; gap: 10px; text-align: center; }
        }
    </style>
</head>
<body>

<canvas id="bg-canvas"></canvas>
<div class="grid-overlay"></div>
<div class="noise"></div>

<div class="page-wrap">

    <!-- HEADER -->
    <header class="site-header">
        <div class="brand">
            <div class="brand-icon"><i class="fas fa-cloud-sun"></i></div>
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

    <!-- MAIN -->
    <div class="main-content">
        <div class="recover-card">

            <!-- Icono -->
            <div class="icon-wrap">
                <i class="fas fa-key"></i>
            </div>

            <!-- Eyebrow con líneas -->
            <div class="eyebrow">
                Recuperación de acceso
            </div>

            <!-- Título -->
            <h1 class="card-title">
                <span class="muted">Restablecer</span>
                <span class="accent">contraseña</span>
            </h1>

            <p class="card-desc">
                Ingresa tu correo electrónico y te enviaremos<br>
                un enlace para restablecer tu acceso al sistema.
            </p>

            <!-- Steps -->
            <div class="steps">
                <div class="step active">
                    <div class="step-num">1</div>
                    <span>Verificar correo</span>
                </div>
                <div class="step-sep"></div>
                <div class="step">
                    <div class="step-num">2</div>
                    <span>Revisar email</span>
                </div>
                <div class="step-sep"></div>
                <div class="step">
                    <div class="step-num">3</div>
                    <span>Nueva contraseña</span>
                </div>
            </div>

            <!-- Mensajes flash -->
            <?php if (session()->getFlashdata('ok')): ?>
            <div class="msg msg-ok">
                <i class="fas fa-circle-check" style="margin-top:1px; flex-shrink:0;"></i>
                <?= session()->getFlashdata('ok') ?>
            </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
            <div class="msg msg-error">
                <i class="fas fa-circle-exclamation" style="margin-top:1px; flex-shrink:0;"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
            <?php endif; ?>

            <!-- Formulario -->
            <form action="<?= base_url('recuperarpassword/enviar') ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope" style="margin-right:5px; font-size:10px;"></i>
                        Correo electrónico registrado
                    </label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email"
                               placeholder="tu@correo.com"
                               required autofocus>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane" style="font-size:12px;"></i>
                    Enviar enlace de recuperación
                </button>
            </form>

            <!-- Footer card -->
            <div class="card-footer">
                  <a href="<?= base_url('login') ?>" class="btn-back">
        ¿Recordaste tu contraseña? Iniciar sesión
    </a>
                  <!-- BOTÓN VOLVER (ARREGLADO) -->
    <a href="<?= base_url('login') ?>" class="btn-back">
        ← Volver al login
    </a>
            </div>

        </div>
    </div>

    <!-- FOOTER -->
    <footer class="site-footer">
        <span class="footer-copy">© <?= date('Y') ?> CO Monitor — Sistema de Detección de CO</span>
        <nav class="footer-links">
            <a href__="#">Documentación</a>
            <a href__="#">Soporte</a>
            <a href__="#">Privacidad</a>
        </nav>
    </footer>

</div>

<script>
/* ── PARTÍCULAS ── */
const canvas = document.getElementById('bg-canvas');
const ctx    = canvas.getContext('2d');
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
        this.vx = (Math.random() - 0.5) * 0.22;
        this.vy = (Math.random() - 0.5) * 0.22;
        this.a  = Math.random() * 0.4 + 0.04;
    }
    update() {
        this.x += this.vx; this.y += this.vy;
        if (this.x < 0 || this.x > W || this.y < 0 || this.y > H) this.reset();
    }
    draw() {
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(56,189,248,${this.a})`;
        ctx.fill();
    }
}

function drawConnections() {
    const dist = 110;
    for (let i = 0; i < particles.length; i++) {
        for (let j = i + 1; j < particles.length; j++) {
            const dx = particles[i].x - particles[j].x;
            const dy = particles[i].y - particles[j].y;
            const d  = Math.sqrt(dx*dx + dy*dy);
            if (d < dist) {
                ctx.beginPath();
                ctx.moveTo(particles[i].x, particles[i].y);
                ctx.lineTo(particles[j].x, particles[j].y);
                ctx.strokeStyle = `rgba(56,189,248,${(1 - d/dist) * 0.10})`;
                ctx.lineWidth = 0.5; ctx.stroke();
            }
        }
    }
}

function drawOrbs() {
    [
        { x: W*0.20, y: H*0.80, r: 260, c: 'rgba(14,165,233,0.055)' },
        { x: W*0.80, y: H*0.20, r: 220, c: 'rgba(56,189,248,0.045)' },
        { x: W*0.50, y: H*1.05, r: 240, c: 'rgba(3,105,161,0.06)'   },
    ].forEach(o => {
        const g = ctx.createRadialGradient(o.x, o.y, 0, o.x, o.y, o.r);
        g.addColorStop(0, o.c); g.addColorStop(1, 'transparent');
        ctx.fillStyle = g;
        ctx.beginPath(); ctx.arc(o.x, o.y, o.r, 0, Math.PI*2); ctx.fill();
    });
}

function loop() {
    ctx.clearRect(0, 0, W, H);
    drawOrbs(); drawConnections();
    particles.forEach(p => { p.update(); p.draw(); });
    requestAnimationFrame(loop);
}

resize();
particles = Array.from({ length: 55 }, () => new Particle());
loop();
window.addEventListener('resize', () => {
    resize();
    particles = Array.from({ length: 55 }, () => new Particle());
});
</script>

</body>
</html>