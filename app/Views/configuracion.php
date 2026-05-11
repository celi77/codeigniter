<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Configuración</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
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
      padding: 36px 32px 70px;
      animation: fade-up 0.6s ease both;
    }

    /* ── TOPBAR ── */
    .page-header {
      display: flex; align-items: center; justify-content: space-between;
      margin-bottom: 32px;
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
      font-family: 'Syne', sans-serif; font-size: 24px; font-weight: 800;
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

    /* ── LAYOUT ── */
    .config-layout {
      display: grid;
      grid-template-columns: 220px 1fr;
      gap: 20px;
      align-items: start;
    }

    /* ── SIDEBAR ── */
    .config-sidebar {
      background: var(--bg-card);
      backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px);
      border: 1px solid var(--border);
      border-radius: 18px;
      padding: 14px;
      position: sticky; top: 32px;
      box-shadow: 0 30px 60px rgba(0,0,0,0.5);
      animation: fade-up 0.65s ease 0.1s both;
    }

    .sidebar-label {
      font-size: 9px; letter-spacing: 0.12em; text-transform: uppercase;
      color: var(--muted); padding: 8px 10px 6px; display: block;
    }

    .nav-link {
      display: flex; align-items: center; gap: 10px;
      padding: 11px 14px; border-radius: 12px;
      color: #94a3b8; font-size: 13px; font-weight: 400;
      border: none; background: transparent; width: 100%;
      text-align: left; cursor: pointer; margin-bottom: 2px;
      transition: all 0.18s ease; font-family: 'DM Sans', sans-serif;
    }
    .nav-link i { font-size: 13px; opacity: 0.7; width: 16px; text-align: center; }
    .nav-link:hover { background: rgba(56,189,248,0.07); color: var(--blue); }
    .nav-link:hover i { opacity: 1; }
    .nav-link.active {
      background: rgba(56,189,248,0.1); color: var(--blue);
      border: 1px solid rgba(56,189,248,0.18); font-weight: 500;
    }
    .nav-link.active i { opacity: 1; }

    /* ── CONTENT CARD ── */
    .config-content {
      background: var(--bg-card);
      backdrop-filter: blur(28px); -webkit-backdrop-filter: blur(28px);
      border: 1px solid var(--border);
      border-radius: 20px; overflow: hidden;
      box-shadow: 0 60px 120px rgba(0,0,0,0.55), inset 0 1px 0 rgba(56,189,248,0.08);
      animation: fade-up 0.7s ease 0.15s both;
    }

    .tab-pane { display: none; }
    .tab-pane.active { display: block; }

    .pane-header {
      padding: 22px 28px;
      border-bottom: 1px solid var(--border-s);
      background: linear-gradient(to right, rgba(56,189,248,0.03), transparent);
      position: relative;
    }
    .pane-header::before {
      content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
      background: linear-gradient(90deg, var(--blue), transparent);
    }

    .pane-title {
      font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700;
      color: var(--text); display: flex; align-items: center; gap: 10px;
    }
    .pane-title i { color: var(--blue); font-size: 14px; }
    .pane-subtitle { font-size: 12px; color: var(--muted); margin-top: 3px; }

    .pane-body { padding: 28px; }

    /* ── TABLA USUARIOS ── */
    .glass-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .glass-table thead th {
      font-family: 'Syne', sans-serif; font-size: 10px;
      letter-spacing: 0.1em; text-transform: uppercase; color: var(--muted); font-weight: 600;
      padding: 12px 16px; border-bottom: 1px solid var(--border-s);
      background: rgba(56,189,248,0.02);
    }
    .glass-table tbody td {
      padding: 13px 16px; border-bottom: 1px solid var(--border-s);
      color: var(--text); vertical-align: middle;
    }
    .glass-table tbody tr:last-child td { border-bottom: none; }
    .glass-table tbody tr { transition: background 0.15s ease; }
    .glass-table tbody tr:hover { background: rgba(56,189,248,0.025); }

    .row-id { font-family: 'Syne', sans-serif; font-size: 12px; color: var(--muted); }

    /* SELECTS */
    .form-select, .form-control {
      background: rgba(255,255,255,0.03);
      border: 1px solid var(--border-s);
      border-radius: 10px;
      color: var(--text);
      font-family: 'DM Sans', sans-serif;
      font-size: 13px;
      padding: 8px 12px;
      transition: border-color 0.18s, box-shadow 0.18s;
    }
    .form-select:focus, .form-control:focus {
      border-color: rgba(56,189,248,0.4);
      box-shadow: 0 0 0 3px rgba(56,189,248,0.08);
      background: rgba(56,189,248,0.03); color: var(--text); outline: none;
    }
    .form-select option { background: #0a1022; color: var(--text); }

    /* LABELS */
    .form-label {
      font-size: 11px; letter-spacing: 0.07em; text-transform: uppercase;
      color: var(--muted); font-weight: 500; margin-bottom: 7px; display: block;
    }

    /* BTN SAVE ICON */
    .btn-save-icon {
      display: inline-flex; align-items: center; justify-content: center;
      width: 32px; height: 32px; border-radius: 9px;
      background: rgba(56,189,248,0.1); border: 1px solid rgba(56,189,248,0.2);
      color: var(--blue); font-size: 12px; cursor: pointer;
      transition: all 0.18s ease;
    }
    .btn-save-icon:hover { background: rgba(56,189,248,0.2); transform: translateY(-1px); }

    /* BTN PRIMARY */
    .btn-primary-custom {
      display: inline-flex; align-items: center; justify-content: center; gap: 8px;
      width: 100%; padding: 13px 20px; border-radius: 12px;
      background: linear-gradient(135deg, var(--blue), var(--blue-dk));
      border: none; color: #fff;
      font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 500;
      cursor: pointer; position: relative; overflow: hidden;
      box-shadow: 0 8px 28px rgba(14,165,233,0.25), inset 0 1px 0 rgba(255,255,255,0.15);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .btn-primary-custom::after {
      content: ''; position: absolute; top: 0; left: -100%; width: 60%; height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
      transition: left 0.5s ease;
    }
    .btn-primary-custom:hover { transform: translateY(-2px); box-shadow: 0 16px 40px rgba(14,165,233,0.38); }
    .btn-primary-custom:hover::after { left: 140%; }

    /* ALERTA MINI CARDS */
    .alert-mini-card {
      background: rgba(255,255,255,0.02);
      border: 1px solid var(--border-s);
      border-radius: 14px; padding: 18px;
      transition: border-color 0.18s;
    }
    .alert-mini-card:hover { border-color: var(--border); }

    /* ── ANIM ── */
    @keyframes fade-up {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 900px) {
      .config-layout { grid-template-columns: 1fr; }
      .config-sidebar { position: static; }
      .page-wrap { padding: 24px 16px 50px; }
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
        <div class="header-title">Configuración del Sistema</div>
      </div>
    </div>
    <a href="<?= base_url('vistaprincipal') ?>" class="btn-back">
      <i class="fas fa-arrow-left"></i> Volver
    </a>
  </div>

  <div class="config-layout">

    <!-- SIDEBAR -->
    <aside class="config-sidebar">
      <span class="sidebar-label">Secciones</span>

      <button class="nav-link active" onclick="switchTab(this,'usuarios')">
        <i class="fas fa-users"></i> Usuarios
      </button>
      <button class="nav-link" onclick="switchTab(this,'alertas')">
        <i class="fas fa-bell"></i> Alertas
      </button>
      <button class="nav-link" onclick="switchTab(this,'nuevo')">
        <i class="fas fa-user-plus"></i> Nuevo Usuario
      </button>
      <button class="nav-link" onclick="switchTab(this,'sensores')">
        <i class="fas fa-microchip"></i> Nuevo Sensor
      </button>
    </aside>

    <!-- CONTENT -->
    <div class="config-content">

      <!-- ── USUARIOS ── -->
      <div class="tab-pane active" id="tab-usuarios">
        <div class="pane-header">
          <div class="pane-title"><i class="fas fa-users"></i> Gestión de Usuarios</div>
          <div class="pane-subtitle">Administrá roles y permisos del sistema</div>
        </div>
        <div class="pane-body">
          <div class="table-responsive">
            <table class="glass-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Email</th>
                  <th>Rol</th>
                  <th>Guardar</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($usuarios as $user): ?>
                <tr>
                  <td><span class="row-id">#<?= str_pad($user['id'], 3, '0', STR_PAD_LEFT) ?></span></td>
                  <td><?= $user['nombre'] ?></td>
                  <td style="color:var(--muted);font-size:12px;"><?= $user['email'] ?></td>
                  <td>
                    <form action="<?= base_url('configuracion/actualizarRol') ?>" method="post" id="form-<?= $user['id'] ?>">
                      <input type="hidden" name="id" value="<?= $user['id'] ?>">
                      <select name="rol" class="form-select form-select-sm">
                        <option value="admin"   <?= $user['rol'] == 'admin'   ? 'selected' : '' ?>>Administrador</option>
                        <option value="usuario" <?= $user['rol'] == 'usuario' ? 'selected' : '' ?>>Usuario</option>
                      </select>
                  </td>
                  <td>
                      <button type="submit" class="btn-save-icon" form="form-<?= $user['id'] ?>">
                        <i class="fas fa-save"></i>
                      </button>
                    </form>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ── ALERTAS ── -->
      <div class="tab-pane" id="tab-alertas">
        <div class="pane-header">
          <div class="pane-title"><i class="fas fa-bell"></i> Configuración de Alertas</div>
          <div class="pane-subtitle">Umbrales y canales de notificación</div>
        </div>
        <div class="pane-body">
          <div class="row g-3">
            <div class="col-md-6">
              <div class="alert-mini-card">
                <label class="form-label">Estado de alertas</label>
                <select class="form-select">
                  <option>Activadas</option>
                  <option>Desactivadas</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="alert-mini-card">
                <label class="form-label">Tipo de notificación</label>
                <select class="form-select">
                  <option>Email</option>
                  <option>Sistema</option>
                  <option>Ambas</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="alert-mini-card">
                <label class="form-label">Umbral mínimo</label>
                <input type="number" class="form-control" placeholder="Ej: 10">
              </div>
            </div>
            <div class="col-md-6">
              <div class="alert-mini-card">
                <label class="form-label">Umbral máximo</label>
                <input type="number" class="form-control" placeholder="Ej: 80">
              </div>
              
            </div>
             <button type="submit" class="btn-primary-custom">
                <i class="fas fa-plus"></i> Guardar cambios
              </button>
          </div>
        </div>
      </div>

     <!-- ── NUEVO USUARIO ── -->
<div class="tab-pane" id="tab-nuevo">
  <div class="pane-header">
    <div class="pane-title">
      <i class="fas fa-user-plus"></i> Crear Nuevo Usuario
    </div>
    <div class="pane-subtitle">
      Agregá un nuevo usuario al sistema
    </div>
  </div>

  <div class="pane-body">

    <form action="<?= base_url('configuracion/crearUsuario') ?>" method="post" class="row g-3">

      <div class="col-md-6">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" placeholder="Nombre completo">
      </div>

      <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="correo@ejemplo.com">
      </div>

      <div class="col-md-6">
        <label class="form-label">Contraseña</label>
        <input type="password" name="password" class="form-control" placeholder="••••••••">
      </div>

      <div class="col-md-6">
        <label class="form-label">Rol</label>
        <select name="rol" class="form-select">
          <option value="admin">Administrador</option>
          <option value="usuario">Usuario</option>
        </select>
      </div>

      <div class="col-12">
        <button type="submit" class="btn-primary-custom">
          <i class="fas fa-user-plus"></i> Crear usuario
        </button>
      </div>

    </form>

  </div>
</div>

     <!-- ── NUEVO SENSOR ── -->
<div class="tab-pane" id="tab-sensores">
  <div class="pane-header">
    <div class="pane-title">
      <i class="fas fa-microchip"></i> Agregar Nuevo Sensor
    </div>
    <div class="pane-subtitle">
      Registrá un sensor en el sistema
    </div>
  </div>

  <div class="pane-body">
    <form action="<?= base_url('configuracion/guardarSensor') ?>" method="post" class="row g-3">

      <div class="col-md-6">
        <label class="form-label">Sector</label>
        <input type="text" name="sector" class="form-control"
               placeholder="Ej: Cocina, Aula 3" required>
      </div>

      <div class="col-md-6">
        <label class="form-label">Funcionamiento</label>
        <select name="funcionamiento" class="form-select">
          <option value="activado">Activado</option>
          <option value="mantenimiento">En mantenimiento</option>
        </select>
      </div>

      <!-- NUEVO CAMPO -->
      <div class="col-md-6">
        <label class="form-label">Umbral de CO (PPM)</label>
        <input type="number" name="valor_ppm" class="form-control"
               placeholder="Ej: 50" min="0" required>
      </div>

      <div class="col-12">
        <button type="submit" class="btn-primary-custom">
          <i class="fas fa-plus"></i> Crear sensor
        </button>
      </div>

    </form>
  </div>
</div>
    </div><!-- /config-content -->
  </div><!-- /config-layout -->
</div><!-- /page-wrap -->

<script>
/* ── TAB SWITCHER (reemplaza Bootstrap Pills) ── */
function switchTab(btn, id) {
  document.querySelectorAll('.nav-link').forEach(b => b.classList.remove('active'));
  document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById('tab-' + id).classList.add('active');
}

/* ── PARTÍCULAS ── */
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>