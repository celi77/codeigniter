<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vista General - CO System</title>
 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
 
  <style>
    /* ── RESET & BASE ── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
 
    :root {
      --blue:     #38bdf8;
      --blue-dk:  #0ea5e9;
      --bg-deep:  #050814;
      --bg-mid:   #080f1e;
      --bg-card:  rgba(10, 16, 34, 0.82);
      --border:   rgba(56,189,248,0.14);
      --border-s: rgba(56,189,248,0.08);
      --text:     #e2e8f0;
      --muted:    #64748b;
      --sidebar-w: 248px;
    }
 
    html, body {
      min-height: 100vh;
      background: var(--bg-deep);
      color: var(--text);
      font-family: 'DM Sans', sans-serif;
      overflow-x: hidden;
    }
 
    /* ── FONDO GLOBAL ── */
    #bg-canvas {
      position: fixed; inset: 0; z-index: 0; pointer-events: none;
    }
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
 
    /* ── SIDEBAR ── */
    .sidebar {
      position: fixed;
      top: 0; left: 0;
      width: var(--sidebar-w);
      height: 100vh;
      z-index: 100;
      display: flex;
      flex-direction: column;
      background: rgba(8, 13, 28, 0.92);
      backdrop-filter: blur(24px);
      -webkit-backdrop-filter: blur(24px);
      border-right: 1px solid var(--border);
      box-shadow: 4px 0 40px rgba(0,0,0,0.5);
    }
 
    .sidebar-brand {
      padding: 26px 22px 22px;
      border-bottom: 1px solid var(--border-s);
      display: flex;
      align-items: center;
      gap: 12px;
    }
 
    .brand-icon-sm {
      width: 36px; height: 36px;
      border-radius: 10px;
      background: rgba(56,189,248,0.1);
      border: 1px solid var(--border);
      display: flex; align-items: center; justify-content: center;
      font-size: 16px; color: var(--blue);
      flex-shrink: 0;
    }
 
    .brand-text-wrap .brand-name {
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 14px;
      color: var(--text);
      display: block;
    }
 
    .brand-text-wrap .brand-sub {
      font-size: 10px;
      color: var(--muted);
      letter-spacing: 0.07em;
      text-transform: uppercase;
    }
 
    /* NAV */
    .sidebar-nav {
      padding: 16px 12px;
      flex: 1;
      overflow-y: auto;
    }
 
    .nav-section-label {
      font-size: 9px;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--muted);
      padding: 12px 10px 6px;
      display: block;
    }
 
    .sidebar-nav a {
      display: flex;
      align-items: center;
      gap: 11px;
      padding: 11px 14px;
      border-radius: 12px;
      color: #94a3b8;
      text-decoration: none;
      font-size: 14px;
      font-weight: 400;
      transition: all 0.18s ease;
      margin-bottom: 2px;
    }
 
    .sidebar-nav a i {
      width: 16px;
      text-align: center;
      font-size: 13px;
      opacity: 0.7;
      transition: opacity 0.18s;
    }
 
    .sidebar-nav a:hover {
      background: rgba(56,189,248,0.07);
      color: var(--blue);
    }
    .sidebar-nav a:hover i { opacity: 1; }
 
    .sidebar-nav a.active {
      background: rgba(56,189,248,0.1);
      color: var(--blue);
      border: 1px solid rgba(56,189,248,0.18);
      font-weight: 500;
    }
    .sidebar-nav a.active i { opacity: 1; }
 
    .sidebar-nav a.text-danger { color: #f87171 !important; }
    .sidebar-nav a.text-danger:hover { background: rgba(239,68,68,0.08); color: #f87171; }
 
    /* SIDEBAR BOTTOM */
    .sidebar-footer {
      padding: 12px 12px 20px;
      border-top: 1px solid var(--border-s);
    }
 
    /* ── MAIN ── */
    .main-content {
      margin-left: var(--sidebar-w);
      padding: 32px 40px;
      position: relative;
      z-index: 10;
      min-height: 100vh;
    }
 
    /* ── TOPBAR ── */
    .topbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 32px;
      padding-bottom: 24px;
      border-bottom: 1px solid var(--border-s);
    }
 
    .topbar-left {}
 
    .page-eyebrow {
      font-size: 10px;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--muted);
      margin-bottom: 4px;
    }
 
    .page-title {
      font-family: 'Syne', sans-serif;
      font-size: 26px;
      font-weight: 700;
      color: var(--text);
    }
 
    .topbar-right {
      display: flex;
      align-items: center;
      gap: 14px;
    }
 
    .live-badge {
      display: flex;
      align-items: center;
      gap: 7px;
      padding: 7px 14px;
      border-radius: 100px;
      background: rgba(56,189,248,0.06);
      border: 1px solid rgba(56,189,248,0.15);
      font-size: 11px;
      color: var(--blue);
      letter-spacing: 0.04em;
    }
 
    .pulse-dot {
      width: 7px; height: 7px;
      border-radius: 50%;
      background: #22c55e;
      box-shadow: 0 0 0 0 rgba(34,197,94,0.6);
      animation: pulse-ring 2s ease-out infinite;
      flex-shrink: 0;
    }
 
    @keyframes pulse-ring {
      0%   { box-shadow: 0 0 0 0   rgba(34,197,94,0.6); }
      70%  { box-shadow: 0 0 0 8px rgba(34,197,94,0);   }
      100% { box-shadow: 0 0 0 0   rgba(34,197,94,0);   }
    }
 
    .user-chip {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 8px 14px 8px 8px;
      border-radius: 12px;
      background: rgba(255,255,255,0.03);
      border: 1px solid var(--border-s);
    }
 
    .user-avatar {
      width: 32px; height: 32px;
      border-radius: 9px;
      background: rgba(56,189,248,0.12);
      border: 1px solid var(--border);
      display: flex; align-items: center; justify-content: center;
      font-size: 14px; color: var(--blue);
    }
 
    .user-name {
      font-size: 13px;
      font-weight: 500;
      color: var(--text);
    }
 
    /* ── KPI CARDS ── */
    .kpi-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
      margin-bottom: 28px;
    }
 
    .kpi-card {
      background: var(--bg-card);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid var(--border-s);
      border-radius: 18px;
      padding: 22px 20px;
      position: relative;
      overflow: hidden;
      transition: transform 0.2s ease, border-color 0.2s ease;
      animation: fade-in-up 0.6s ease both;
    }
 
    .kpi-card:hover {
      transform: translateY(-3px);
      border-color: rgba(56,189,248,0.22);
    }
 
    .kpi-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 2px;
      border-radius: 18px 18px 0 0;
    }
 
    .kpi-blue::before  { background: linear-gradient(90deg, #38bdf8, #0ea5e9); }
    .kpi-green::before { background: linear-gradient(90deg, #22c55e, #16a34a); }
    .kpi-yellow::before{ background: linear-gradient(90deg, #facc15, #f59e0b); }
    .kpi-red::before   { background: linear-gradient(90deg, #ef4444, #dc2626); }
 
    .kpi-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 16px;
    }
 
    .kpi-label {
      font-size: 11px;
      letter-spacing: 0.07em;
      text-transform: uppercase;
      color: var(--muted);
      font-weight: 400;
    }
 
    .kpi-icon {
      width: 32px; height: 32px;
      border-radius: 9px;
      display: flex; align-items: center; justify-content: center;
      font-size: 13px;
    }
 
    .kpi-blue  .kpi-icon { background: rgba(56,189,248,0.1);  color: #38bdf8; }
    .kpi-green .kpi-icon { background: rgba(34,197,94,0.1);   color: #22c55e; }
    .kpi-yellow.kpi-icon { background: rgba(250,204,21,0.1);  color: #facc15; }
    .kpi-red   .kpi-icon { background: rgba(239,68,68,0.1);   color: #ef4444; }
    .kpi-yellow .kpi-icon { background: rgba(250,204,21,0.1); color: #facc15; }
    .kpi-red    .kpi-icon { background: rgba(239,68,68,0.1);  color: #ef4444; }
 
    .kpi-value {
      font-family: 'Syne', sans-serif;
      font-size: 36px;
      font-weight: 800;
      line-height: 1;
      display: block;
    }
 
    .kpi-blue  .kpi-value { color: #38bdf8; }
    .kpi-green .kpi-value { color: #4ade80; }
    .kpi-yellow .kpi-value { color: #fde047; }
    .kpi-red   .kpi-value { color: #f87171; }
 
    /* Estado dinámico */
    .kpi-value.text-success { color: #4ade80 !important; }
    .kpi-value.text-danger  { color: #f87171 !important; }
 
    /* ── SECCIÓN ADMIN SOLICITUDES ── */
    .section-divider {
      display: flex;
      align-items: center;
      gap: 14px;
      margin: 32px 0 20px;
    }
 
    .section-divider h4 {
      font-family: 'Syne', sans-serif;
      font-size: 16px;
      font-weight: 700;
      color: var(--text);
      white-space: nowrap;
    }
 
    .section-divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--border-s);
    }
 
    /* ── TABLA SOLICITUDES ── */
    .glass-table-wrap {
      background: var(--bg-card);
      backdrop-filter: blur(20px);
      border: 1px solid var(--border-s);
      border-radius: 18px;
      overflow: hidden;
      margin-bottom: 28px;
    }
 
    .glass-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13px;
    }
 
    .glass-table thead th {
      font-family: 'Syne', sans-serif;
      font-size: 10px;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--muted);
      font-weight: 600;
      padding: 14px 20px;
      border-bottom: 1px solid var(--border-s);
      background: rgba(56,189,248,0.03);
    }
 
    .glass-table tbody td {
      padding: 13px 20px;
      border-bottom: 1px solid var(--border-s);
      color: var(--text);
      vertical-align: middle;
    }
 
    .glass-table tbody tr:last-child td { border-bottom: none; }
 
    .glass-table tbody tr {
      transition: background 0.15s ease;
    }
    .glass-table tbody tr:hover { background: rgba(56,189,248,0.03); }
 
    /* Botones tabla */
    .btn-success.btn-sm {
      background: rgba(34,197,94,0.15);
      border: 1px solid rgba(34,197,94,0.3);
      color: #4ade80;
      border-radius: 8px;
      padding: 5px 12px;
      font-size: 12px;
      transition: all 0.18s;
    }
    .btn-success.btn-sm:hover {
      background: rgba(34,197,94,0.25);
      color: #4ade80;
    }
 
    .btn-danger.btn-sm {
      background: rgba(239,68,68,0.15);
      border: 1px solid rgba(239,68,68,0.3);
      color: #f87171;
      border-radius: 8px;
      padding: 5px 12px;
      font-size: 12px;
      transition: all 0.18s;
    }
    .btn-danger.btn-sm:hover {
      background: rgba(239,68,68,0.25);
      color: #f87171;
    }
 
    /* ── CARD SENSORES ── */
    .sensors-card {
      background: var(--bg-card);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid var(--border-s);
      border-radius: 18px;
      overflow: hidden;
      animation: fade-in-up 0.7s ease 0.3s both;
    }
 
    .sensors-card-header {
      padding: 20px 24px;
      border-bottom: 1px solid var(--border-s);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
 
    .sensors-card-header h5 {
      font-family: 'Syne', sans-serif;
      font-size: 15px;
      font-weight: 700;
      color: var(--text);
      display: flex;
      align-items: center;
      gap: 10px;
    }
 
    .sensors-card-header h5 i { color: var(--blue); font-size: 14px; }
 
    .sensors-count-badge {
      font-size: 11px;
      padding: 4px 12px;
      border-radius: 100px;
      background: rgba(56,189,248,0.08);
      border: 1px solid rgba(56,189,248,0.18);
      color: var(--blue);
    }
 
    .activity-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 14px 24px;
      border-bottom: 1px solid var(--border-s);
      transition: background 0.15s ease;
    }
 
    .activity-item:last-child { border-bottom: none; }
    .activity-item:hover { background: rgba(56,189,248,0.03); }
 
    .activity-left {
      display: flex;
      align-items: center;
      gap: 14px;
    }
 
    .sensor-dot {
      width: 8px; height: 8px;
      border-radius: 50%;
      flex-shrink: 0;
    }
 
    .sensor-dot.active { background: #22c55e; box-shadow: 0 0 6px rgba(34,197,94,0.5); }
    .sensor-dot.inactive { background: #ef4444; }
 
    .sensor-name {
      font-size: 14px;
      font-weight: 400;
      color: var(--text);
    }
 
    .sensor-meta {
      font-size: 11px;
      color: var(--muted);
      margin-top: 1px;
    }
 
    /* BADGES */
    .badge-soft {
      font-size: 11px;
      padding: 5px 12px;
      border-radius: 100px;
      font-weight: 500;
      letter-spacing: 0.03em;
    }
 
    .ok   { background: rgba(34,197,94,0.12);  border: 1px solid rgba(34,197,94,0.25);  color: #4ade80; }
    .warn { background: rgba(250,204,21,0.12); border: 1px solid rgba(250,204,21,0.25); color: #fde047; }
    .bad  { background: rgba(239,68,68,0.12);  border: 1px solid rgba(239,68,68,0.25);  color: #f87171; }
 
    /* ── ANIMACIONES ── */
    @keyframes fade-in-up {
      from { opacity: 0; transform: translateY(18px); }
      to   { opacity: 1; transform: translateY(0);    }
    }
 
    .kpi-card:nth-child(1) { animation-delay: 0.05s; }
    .kpi-card:nth-child(2) { animation-delay: 0.12s; }
    .kpi-card:nth-child(3) { animation-delay: 0.19s; }
    .kpi-card:nth-child(4) { animation-delay: 0.26s; }
 
    /* ── RESPONSIVE ── */
    @media (max-width: 1100px) {
      .kpi-grid { grid-template-columns: repeat(2, 1fr); }
    }
 
    @media (max-width: 768px) {
      .sidebar { transform: translateX(-100%); }
      .main-content { margin-left: 0; padding: 20px; }
      .kpi-grid { grid-template-columns: 1fr 1fr; }
    }
 
    /* ── OVERRIDE Bootstrap resets ── */
    h1,h2,h3,h4,h5,h6,strong { color: var(--text) !important; }
    small, .text-muted { color: var(--muted) !important; }
  </style>
</head>
<body>
 
<!-- FONDO -->
<canvas id="bg-canvas"></canvas>
<div class="grid-overlay"></div>
<div class="noise"></div>
 
<<!-- ══════════ SIDEBAR ══════════ -->
<aside class="sidebar">
 
  <div class="sidebar-brand">
    <div class="brand-icon-sm">
      <i class="fas fa-cloud-sun"></i>
    </div>
    <div class="brand-text-wrap">
      <span class="brand-name">CO Monitor</span>
      <span class="brand-sub">Sistema de Sensores</span>
    </div>
  </div>
 
  <nav class="sidebar-nav">
    <span class="nav-section-label">Principal</span>
 
    <a href="#" class="active">
      <i class="fas fa-home"></i> Vista General
    </a>
    <!-- <a href="<?= base_url('plano') ?>">
      <i class="fas fa-map"></i> Ubicación
    </a> -->
    <a href="<?= base_url('estadisticas') ?>">
      <i class="fas fa-chart-bar"></i> Estadísticas
    </a>
    <a href="<?= base_url('alertas') ?>">
      <i class="fas fa-bell"></i> Alertas
    </a>
 
    <?php if(session()->get('rol') === 'admin'): ?>
      <span class="nav-section-label">Administración</span>
      
      <a href="<?= base_url('configuracion') ?>">
        <i class="fas fa-cog"></i> Configuración
      </a>
    <?php endif; ?>
  </nav>
 
  <div class="sidebar-footer">

    <!-- 🔽 BOTÓN NUEVO AGREGADO ACÁ -->
    <?php if(session()->get('rol') !== 'admin'): ?>
    <a href="<?= base_url('sp/solicitar') ?>" 
       style="display:flex;align-items:center;gap:11px;
              padding:11px 14px;border-radius:12px;
              color:#38bdf8;text-decoration:none;
              font-size:14px;transition:all .18s ease;
              margin-bottom:6px;
              background:rgba(56,189,248,0.06);
              border:1px solid rgba(56,189,248,0.15);"
       onmouseover="this.style.background='rgba(56,189,248,0.12)'"
       onmouseout="this.style.background='rgba(56,189,248,0.06)'">

      <i class="fas fa-user-shield" style="width:16px;text-align:center;font-size:13px;"></i>
      Solicitar ser admin
    </a>
    <?php endif; ?>

    <a href="<?= base_url('miperfil') ?>" style="display:flex;align-items:center;gap:11px;padding:11px 14px;border-radius:12px;color:#94a3b8;text-decoration:none;font-size:14px;transition:all .18s ease;margin-bottom:2px;" onmouseover="this.style.background='rgba(56,189,248,0.07)';this.style.color='#38bdf8'" onmouseout="this.style.background='';this.style.color='#94a3b8'">
      <i class="fas fa-user" style="width:16px;text-align:center;font-size:13px;"></i> Mi Perfil
    </a>

    <a href="<?= base_url('/logout') ?>" class="text-danger" style="display:flex;align-items:center;gap:11px;padding:11px 14px;border-radius:12px;color:#f87171;text-decoration:none;font-size:14px;transition:all .18s ease;" onmouseover="this.style.background='rgba(239,68,68,0.08)'" onmouseout="this.style.background=''">
      <i class="fas fa-sign-out-alt" style="width:16px;text-align:center;font-size:13px;"></i> Salir
    </a>

  </div>
 
</aside>
 
<!-- ══════════ MAIN ══════════ -->
<div class="main-content">
 
  <!-- TOPBAR -->
  <div class="topbar">
    <div class="topbar-left">
      <div class="page-eyebrow">Panel de control</div>
      <div class="page-title">Vista General</div>
    </div>
    <div class="topbar-right">
      <div class="live-badge">
        <div class="pulse-dot"></div>
        En vivo
      </div>
      <div class="user-chip">
        <div class="user-avatar">
          <i class="fas fa-cloud-sun"></i>
        </div>
        <span class="user-name">Hola, <strong><?= session()->get('nombre') ?></strong></span>
      </div>
    </div>
  </div>
 
  <!-- KPI CARDS -->
  <div class="kpi-grid">
 
    <div class="card kpi-card kpi-blue">
      <div class="kpi-header">
        <span class="kpi-label">Total Sensores</span>
        <div class="kpi-icon"><i class="fas fa-microchip"></i></div>
      </div>
      <span class="kpi-value"><?= count($sensores) ?></span>
    </div>
 
    <div class="card kpi-card kpi-red">
      <div class="kpi-header">
        <span class="kpi-label">Alertas</span>
        <div class="kpi-icon" style="background:rgba(239,68,68,0.1);color:#ef4444;"><i class="fas fa-triangle-exclamation"></i></div>
      </div>
      <span class="kpi-value"><?= $alertas ?></span>
    </div>
 
    <div class="card kpi-card kpi-yellow">
      <div class="kpi-header">
        <span class="kpi-label">Temperatura</span>
        <div class="kpi-icon" style="background:rgba(250,204,21,0.1);color:#facc15;"><i class="fas fa-thermometer-half"></i></div>
      </div>
      <span class="kpi-value"><?= $temperatura ?>°C</span>
    </div>
 
    <div class="card kpi-card kpi-green">
      <div class="kpi-header">
        <span class="kpi-label">Estado</span>
        <div class="kpi-icon"><i class="fas fa-shield-check"></i></div>
      </div>
      <span class="kpi-value <?= ($estado == 'ALERTA') ? 'text-danger' : 'text-success' ?>">
        <?= $estado ?>
      </span>
    </div>
 
  </div>
 
  <!-- ADMIN: SOLICITUDES -->
<?php if(session()->get('rol') !== 'admin'): ?>
  <a href="<?= base_url('sp/solicitar') ?>" 
     style="display:flex;align-items:center;gap:11px;
            padding:11px 14px;border-radius:12px;
            color:#38bdf8;text-decoration:none;
            font-size:14px;transition:all .18s ease;"
     onmouseover="this.style.background='rgba(56,189,248,0.07)'"
     onmouseout="this.style.background=''">

    <i class="fas fa-user-shield" style="width:16px;text-align:center;font-size:13px;"></i>
    Solicitar ser admin
  </a>
<?php endif; ?>
 
  <!-- ACTIVIDAD DE SENSORES -->
<div class="sensors-card">

  <div class="sensors-card-header">
    <h5>
      <i class="fas fa-microchip"></i>
      Actividad de Sensores
    </h5>

    <span class="sensors-count-badge">
      <?= count($sensores) ?> sensores
    </span>
  </div>

  
  <?php foreach($sensores as $sensor): ?>

    <div class="activity-item">

      <div class="activity-left">

        <div class="sensor-dot <?= $sensor['funcionamiento'] == 'activo' ? 'active' : 'inactive' ?>"></div>

        <div>
          <div class="sensor-name">
            Sensor <?= esc($sensor['sector']) ?>
          </div>

          <div class="sensor-meta">
            Zona de monitoreo
          </div>
        </div>

      </div>
 
      <div style="display:flex;align-items:center;gap:10px;">

    <span class="badge-soft <?= $sensor['funcionamiento'] == 'activo' ? 'ok' : 'bad' ?>">
        <?= esc($sensor['funcionamiento']) ?>
    </span>
   

    <a href="<?= base_url('sensor/' . $sensor['id']) ?>" 
       style="display:inline-flex;align-items:center;gap:6px;
              padding:5px 12px;border-radius:100px;
              font-size:11px;font-weight:500;text-decoration:none;
              background:rgba(56,189,248,0.08);
              border:1px solid rgba(56,189,248,0.2);
              color:#38bdf8;
              transition:all 0.18s ease;"
       onmouseover="this.style.background='rgba(56,189,248,0.16)';this.style.borderColor='rgba(56,189,248,0.35)'"
       onmouseout="this.style.background='rgba(56,189,248,0.08)';this.style.borderColor='rgba(56,189,248,0.2)'">
        <i class="fas fa-arrow-right" style="font-size:9px;"></i>
        Ver detalle
    </a>

</div>

    </div>

  <?php endforeach; ?>

</div>
<div class="sensors-card" style="margin-top:20px;">

  <div class="sensors-card-header">
    <h5>
      <i class="fas fa-bell"></i>
      Notificaciones
    </h5>

    <span class="sensors-count-badge">
      <?= !empty($solicitudes) ? count($solicitudes) : 0 ?> pendientes
    </span>
  </div>

  <?php if (!empty($solicitudes)): ?>

    <?php foreach($solicitudes as $n): ?>

      <div class="activity-item">

        <div class="activity-left">

          <div class="sensor-dot active"></div>

          <div>
            <div class="sensor-name">
              Usuario #<?= $n['usuario_id'] ?> pidió ser admin
            </div>

            <div class="sensor-meta">
              <?= $n['motivo'] ?>
            </div>
          </div>

        </div>

        <div>
          <span class="badge-soft warn">
            Pendiente
          </span>
        </div>

      </div>

    <?php endforeach; ?>

  <?php else: ?>

    <div class="activity-item">
      <div class="sensor-name">
        No hay notificaciones
      </div>
    </div>

  <?php endif; ?>

</div>
</div><!-- /main-content -->
 
<script>
/* ── PARTÍCULAS (mismo sistema que la bienvenida) ── */
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
    ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2);
    ctx.fillStyle = `rgba(56,189,248,${this.a})`;
    ctx.fill();
  }
}
 
function drawConnections() {
  const dist = 110;
  for (let i = 0; i < particles.length; i++)
    for (let j = i + 1; j < particles.length; j++) {
      const dx = particles[i].x - particles[j].x;
      const dy = particles[i].y - particles[j].y;
      const d  = Math.hypot(dx, dy);
      if (d < dist) {
        ctx.beginPath();
        ctx.moveTo(particles[i].x, particles[i].y);
        ctx.lineTo(particles[j].x, particles[j].y);
        ctx.strokeStyle = `rgba(56,189,248,${(1 - d/dist) * 0.1})`;
        ctx.lineWidth   = 0.5;
        ctx.stroke();
      }
    }
}
 
function drawOrbs() {
  [
    { x: W*0.1,  y: H*0.2,  r: 300, c:'rgba(14,165,233,0.055)' },
    { x: W*0.85, y: H*0.7,  r: 240, c:'rgba(56,189,248,0.045)' },
    { x: W*0.5,  y: H*0.95, r: 280, c:'rgba(3,105,161,0.06)'   },
  ].forEach(o => {
    const g = ctx.createRadialGradient(o.x,o.y,0,o.x,o.y,o.r);
    g.addColorStop(0, o.c); g.addColorStop(1,'transparent');
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
particles = Array.from({length:60}, () => new Particle());
loop();
window.addEventListener('resize', () => { resize(); particles = Array.from({length:60}, () => new Particle()); });
</script>
 
</body>
</html>