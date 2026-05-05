<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $titulo ?></title>
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

    /* ── WRAPPER ── */
    .page-wrap {
      position: relative; z-index: 10;
      min-height: 100vh;
      padding: 40px 20px 60px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    /* ── TOPBAR ── */
    .topbar {
      width: 100%; max-width: 680px;
      display: flex; align-items: center; justify-content: space-between;
      margin-bottom: 36px;
      animation: fade-up 0.6s ease both;
    }

    .brand {
      display: flex; align-items: center; gap: 12px;
    }

    .brand-icon {
      width: 40px; height: 40px;
      border-radius: 11px;
      background: rgba(56,189,248,0.1);
      border: 1px solid var(--border);
      display: flex; align-items: center; justify-content: center;
      font-size: 18px; color: var(--blue);
    }

    .brand-name {
      font-family: 'Syne', sans-serif;
      font-weight: 700; font-size: 15px; color: var(--text);
      display: block;
    }
    .brand-sub {
      font-size: 10px; color: var(--muted);
      text-transform: uppercase; letter-spacing: 0.08em;
    }

    .btn-back {
      display: inline-flex; align-items: center; gap: 8px;
      padding: 9px 18px; border-radius: 12px;
      background: transparent;
      border: 1px solid rgba(148,163,184,0.18);
      color: var(--muted); font-size: 13px; font-family: 'DM Sans', sans-serif;
      cursor: pointer; text-decoration: none;
      transition: all 0.18s ease;
    }
    .btn-back:hover { color: var(--text); border-color: rgba(148,163,184,0.35); background: rgba(148,163,184,0.06); }

    /* ── FLASH ── */
    .flash-msg {
      width: 100%; max-width: 680px;
      margin-bottom: 18px;
      padding: 14px 20px;
      border-radius: 14px;
      background: rgba(34,197,94,0.1);
      border: 1px solid rgba(34,197,94,0.25);
      color: #4ade80;
      font-size: 14px;
      display: flex; align-items: center; gap: 10px;
      animation: fade-up 0.5s ease both;
    }

    /* ── CARD PRINCIPAL ── */
    .profile-card {
      width: 100%; max-width: 680px;
      background: var(--bg-card);
      backdrop-filter: blur(28px);
      -webkit-backdrop-filter: blur(28px);
      border: 1px solid var(--border);
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 60px 120px rgba(0,0,0,0.65), inset 0 1px 0 rgba(56,189,248,0.1);
      animation: fade-up 0.7s ease 0.1s both;
    }

    /* ── AVATAR SECTION ── */
    .avatar-section {
      padding: 44px 40px 32px;
      display: flex; flex-direction: column; align-items: center;
      border-bottom: 1px solid var(--border-s);
      position: relative;
      background: linear-gradient(to bottom, rgba(56,189,248,0.03), transparent);
    }

    /* Línea de acento superior */
    .avatar-section::before {
      content: '';
      position: absolute; top: 0; left: 0; right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--blue), transparent);
    }

    .avatar-wrap {
      position: relative; margin-bottom: 18px;
    }

    .avatar-ring {
      width: 100px; height: 100px;
      border-radius: 24px;
      background: rgba(56,189,248,0.08);
      border: 2px solid var(--border);
      overflow: hidden;
      box-shadow: 0 0 0 6px rgba(56,189,248,0.06), 0 20px 40px rgba(0,0,0,0.4);
    }

    .avatar-ring img {
      width: 100%; height: 100%; object-fit: cover;
    }

    .avatar-btn {
      position: absolute;
      bottom: -6px; right: -6px;
      width: 32px; height: 32px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--blue), var(--blue-dk));
      border: 2px solid var(--bg-deep);
      display: flex; align-items: center; justify-content: center;
      font-size: 12px; color: #fff;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(14,165,233,0.35);
      transition: transform 0.18s ease, box-shadow 0.18s ease;
    }
    .avatar-btn:hover { transform: scale(1.1); box-shadow: 0 6px 18px rgba(14,165,233,0.5); }

    .profile-username {
      font-family: 'Syne', sans-serif;
      font-size: 22px; font-weight: 700;
      color: var(--text);
      margin-bottom: 4px;
    }

    .profile-email {
      font-size: 13px; color: var(--muted);
    }

    /* ── FORM BODY ── */
    .form-body {
      padding: 32px 40px;
    }

    /* SECCIÓN LABEL */
    .section-label {
      font-size: 10px;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--muted);
      margin-bottom: 16px;
      display: flex; align-items: center; gap: 10px;
    }
    .section-label::after {
      content: ''; flex: 1; height: 1px;
      background: var(--border-s);
    }

    /* INPUTS */
    .fields-grid {
      display: grid; grid-template-columns: 1fr 1fr; gap: 16px;
      margin-bottom: 16px;
    }

    .field-group { display: flex; flex-direction: column; gap: 7px; }

    .field-group label {
      font-size: 11px;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      color: var(--muted);
      font-weight: 500;
    }

    .field-input {
      background: rgba(255,255,255,0.03);
      border: 1px solid var(--border-s);
      border-radius: 12px;
      padding: 12px 16px;
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      color: var(--text);
      outline: none;
      width: 100%;
      transition: border-color 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
    }
    .field-input:focus {
      border-color: rgba(56,189,248,0.4);
      box-shadow: 0 0 0 3px rgba(56,189,248,0.08);
      background: rgba(56,189,248,0.03);
    }
    .field-input::placeholder { color: var(--muted); opacity: 0.6; }

    /* CAMPO FULL */
    .field-full { margin-bottom: 24px; }
    .field-full .field-group { width: 100%; }

    /* NOTIFICACIONES */
    .notif-section { margin-top: 8px; }

    .notif-item {
      display: flex; align-items: center; justify-content: space-between;
      padding: 16px 18px;
      border-radius: 14px;
      background: rgba(255,255,255,0.02);
      border: 1px solid var(--border-s);
      margin-bottom: 10px;
      transition: border-color 0.18s ease, background 0.18s ease;
    }
    .notif-item:hover {
      border-color: rgba(56,189,248,0.15);
      background: rgba(56,189,248,0.02);
    }

    .notif-info {}
    .notif-title { font-size: 14px; font-weight: 500; color: var(--text); }
    .notif-desc  { font-size: 12px; color: var(--muted); margin-top: 2px; }

    /* TOGGLE (Tailwind-style, reescrito en CSS puro) */
    .toggle-wrap { position: relative; display: inline-flex; align-items: center; cursor: pointer; }
    .toggle-wrap input { position: absolute; opacity: 0; width: 0; height: 0; }

    .toggle-track {
      width: 44px; height: 24px;
      border-radius: 100px;
      background: rgba(148,163,184,0.2);
      border: 1px solid rgba(148,163,184,0.15);
      position: relative;
      transition: all 0.25s ease;
    }

    .toggle-thumb {
      position: absolute;
      top: 3px; left: 3px;
      width: 16px; height: 16px;
      border-radius: 50%;
      background: #fff;
      box-shadow: 0 2px 6px rgba(0,0,0,0.3);
      transition: transform 0.25s cubic-bezier(0.34,1.56,0.64,1);
    }

    .toggle-wrap input:checked ~ .toggle-track {
      background: linear-gradient(135deg, var(--blue), var(--blue-dk));
      border-color: transparent;
      box-shadow: 0 4px 12px rgba(14,165,233,0.3);
    }

    .toggle-wrap input:checked ~ .toggle-track .toggle-thumb {
      transform: translateX(20px);
    }

    /* BOTÓN GUARDAR */
    .btn-save {
      width: 100%;
      padding: 15px 28px;
      border-radius: 14px;
      background: linear-gradient(135deg, var(--blue), var(--blue-dk));
      border: none;
      color: #fff;
      font-family: 'DM Sans', sans-serif;
      font-size: 15px; font-weight: 500;
      cursor: pointer;
      display: flex; align-items: center; justify-content: center; gap: 10px;
      position: relative; overflow: hidden;
      box-shadow: 0 8px 28px rgba(14,165,233,0.28), inset 0 1px 0 rgba(255,255,255,0.15);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      margin-top: 28px;
    }
    .btn-save::after {
      content: ''; position: absolute;
      top: 0; left: -100%; width: 60%; height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
      transition: left 0.5s ease;
    }
    .btn-save:hover { transform: translateY(-3px); box-shadow: 0 18px 44px rgba(14,165,233,0.42), inset 0 1px 0 rgba(255,255,255,0.15); }
    .btn-save:hover::after { left: 140%; }

    /* ── FOOTER ── */
    .page-footer {
      margin-top: 28px;
      font-size: 11px; color: var(--muted);
      text-align: center;
      opacity: 0.7;
      animation: fade-up 0.7s ease 0.3s both;
    }

    /* ── ANIMACIONES ── */
    @keyframes fade-up {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0);    }
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 600px) {
      .form-body { padding: 24px 22px; }
      .avatar-section { padding: 32px 22px 24px; }
      .fields-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

<canvas id="bg-canvas"></canvas>
<div class="grid-overlay"></div>
<div class="noise"></div>

<div class="page-wrap">

  <!-- TOPBAR -->
  <div class="topbar">
    <div class="brand">
      <div class="brand-icon"><i class="fas fa-cloud-sun"></i></div>
      <div>
        <span class="brand-name">CO Monitor</span>
        <span class="brand-sub">Configuración de Perfil</span>
      </div>
    </div>
    <button onclick="window.history.back()" class="btn-back">
      <i class="fas fa-arrow-left"></i> Volver
    </button>
  </div>

  <!-- FLASH -->
  <?php if(session()->getFlashdata('mensaje')): ?>
    <div class="flash-msg">
      <i class="fas fa-check-circle"></i>
      <?= session()->getFlashdata('mensaje') ?>
    </div>
  <?php endif; ?>

  <!-- CARD -->
  <div class="profile-card">

   
    <!-- FORM -->
    <div class="form-body">
      <form action="<?= base_url('miperfil/guardar') ?>" method="post" enctype="multipart/form-data">

        <!-- Datos personales -->
        <div class="section-label">Datos personales</div>

        <div class="fields-grid">
          <div class="field-group">
            <label>Nombre completo</label>
            <input type="text" name="nombre" value="<?= $nombre ?>" class="field-input" placeholder="Tu nombre">
          </div>
          <div class="field-group">
            <label>Nombre de usuario</label>
            <input type="text" name="usuario" value="<?= $usuario ?>" class="field-input" placeholder="@usuario">
          </div>
        </div>

        <div class="field-full">
          <div class="field-group">
            <label>Correo electrónico</label>
            <input type="email" name="email" value="<?= $email ?>" class="field-input" placeholder="correo@ejemplo.com">
          </div>
        </div>

        <!-- Notificaciones -->
        <div class="section-label" style="margin-top:8px;">Preferencias de notificaciones</div>

        <div class="notif-section">

          <div class="notif-item">
            <div class="notif-info">
              <div class="notif-title">Alertas de alto CO</div>
              <div class="notif-desc">Notificaciones cuando se detecten niveles peligrosos</div>
            </div>
            <label class="toggle-wrap">
              <input type="checkbox" name="alertas_co" checked>
              <div class="toggle-track">
                <div class="toggle-thumb"></div>
              </div>
            </label>
          </div>

          <div class="notif-item">
            <div class="notif-info">
              <div class="notif-title">Reportes diarios</div>
              <div class="notif-desc">Resumen diario enviado por email</div>
            </div>
            <label class="toggle-wrap">
              <input type="checkbox" name="reportes_diarios" checked>
              <div class="toggle-track">
                <div class="toggle-thumb"></div>
              </div>
            </label>
          </div>

        </div>

        <!-- Guardar -->
        <button type="submit" class="btn-save">
          <i class="fas fa-save"></i> Guardar Cambios
        </button>

      </form>
    </div>

  </div>

  <div class="page-footer">
    Sistema Inteligente de Monitoreo de Monóxido de Carbono © <?= date('Y') ?>
  </div>

</div>

<script>
/* ── PARTÍCULAS (mismo sistema) ── */
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
    this.r  = Math.random() * 1.3 + 0.3;
    this.vx = (Math.random() - 0.5) * 0.22;
    this.vy = (Math.random() - 0.5) * 0.22;
    this.a  = Math.random() * 0.4 + 0.05;
  }
  update() {
    this.x += this.vx; this.y += this.vy;
    if (this.x < 0 || this.x > W || this.y < 0 || this.y > H) this.reset();
  }
  draw() {
    ctx.beginPath();
    ctx.arc(this.x, this.y, this.r, 0, Math.PI*2);
    ctx.fillStyle = `rgba(56,189,248,${this.a})`;
    ctx.fill();
  }
}

function drawConnections() {
  const dist = 110;
  for (let i = 0; i < particles.length; i++)
    for (let j = i+1; j < particles.length; j++) {
      const dx = particles[i].x - particles[j].x;
      const dy = particles[i].y - particles[j].y;
      const d  = Math.hypot(dx, dy);
      if (d < dist) {
        ctx.beginPath();
        ctx.moveTo(particles[i].x, particles[i].y);
        ctx.lineTo(particles[j].x, particles[j].y);
        ctx.strokeStyle = `rgba(56,189,248,${(1-d/dist)*0.1})`;
        ctx.lineWidth = 0.5;
        ctx.stroke();
      }
    }
}

function drawOrbs() {
  [
    { x:W*0.15, y:H*0.2,  r:280, c:'rgba(14,165,233,0.055)' },
    { x:W*0.85, y:H*0.75, r:220, c:'rgba(56,189,248,0.045)' },
    { x:W*0.5,  y:H*1.0,  r:260, c:'rgba(3,105,161,0.06)'   },
  ].forEach(o => {
    const g = ctx.createRadialGradient(o.x,o.y,0,o.x,o.y,o.r);
    g.addColorStop(0,o.c); g.addColorStop(1,'transparent');
    ctx.fillStyle = g;
    ctx.beginPath(); ctx.arc(o.x,o.y,o.r,0,Math.PI*2); ctx.fill();
  });
}

function loop() {
  ctx.clearRect(0,0,W,H);
  drawOrbs(); drawConnections();
  particles.forEach(p => { p.update(); p.draw(); });
  requestAnimationFrame(loop);
}

resize();
particles = Array.from({length:55}, () => new Particle());
loop();
window.addEventListener('resize', () => { resize(); particles = Array.from({length:55}, () => new Particle()); });

/* ── TOGGLE FIX (reflow para :checked pseudo) ── */
document.querySelectorAll('.toggle-wrap input').forEach(inp => {
  inp.addEventListener('change', () => {
    const track = inp.nextElementSibling;
    if (inp.checked) {
      track.style.background = 'linear-gradient(135deg,#38bdf8,#0ea5e9)';
      track.style.borderColor = 'transparent';
      track.style.boxShadow = '0 4px 12px rgba(14,165,233,0.3)';
      track.querySelector('.toggle-thumb').style.transform = 'translateX(20px)';
    } else {
      track.style.background = '';
      track.style.borderColor = '';
      track.style.boxShadow = '';
      track.querySelector('.toggle-thumb').style.transform = '';
    }
  });
  // Inicializar estado
  if (inp.checked) {
    const track = inp.nextElementSibling;
    track.style.background = 'linear-gradient(135deg,#38bdf8,#0ea5e9)';
    track.style.borderColor = 'transparent';
    track.style.boxShadow = '0 4px 12px rgba(14,165,233,0.3)';
    track.querySelector('.toggle-thumb').style.transform = 'translateX(20px)';
  }
});
</script>

</body>
</html>