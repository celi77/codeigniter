<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sensor - <?= esc($sensor['sector']) ?></title>

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

    html, body { min-height: 100vh; background: var(--bg-deep); color: var(--text); font-family: 'DM Sans', sans-serif; overflow-x: hidden; }

    #bg-canvas { position: fixed; inset: 0; z-index: 0; pointer-events: none; }
    .grid-overlay {
      position: fixed; inset: 0; z-index: 1; pointer-events: none;
      background-image: linear-gradient(rgba(56,189,248,0.035) 1px, transparent 1px), linear-gradient(90deg, rgba(56,189,248,0.035) 1px, transparent 1px);
      background-size: 72px 72px;
    }
    .noise { position: fixed; inset: 0; z-index: 2; opacity: 0.022; pointer-events: none; background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E"); }

    .page-wrap { position: relative; z-index: 10; max-width: 920px; margin: 0 auto; padding: 40px 28px 70px; }

    /* ── HEADER ── */
    .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 36px; animation: fade-up 0.6s ease both; }
    .header-left { display: flex; align-items: center; gap: 16px; }
    .brand-icon { width: 44px; height: 44px; border-radius: 12px; background: rgba(56,189,248,0.1); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; font-size: 20px; color: var(--blue); }
    .header-eyebrow { font-size: 10px; letter-spacing: 0.12em; text-transform: uppercase; color: var(--muted); margin-bottom: 3px; }
    .header-title { font-family: 'Syne', sans-serif; font-size: 26px; font-weight: 800; background: linear-gradient(100deg, #e0f2fe 10%, var(--blue) 70%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-transform: capitalize; }

    .btn-back { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 12px; background: transparent; border: 1px solid rgba(148,163,184,0.18); color: var(--muted); font-size: 13px; font-family: 'DM Sans', sans-serif; text-decoration: none; transition: all 0.18s ease; }
    .btn-back:hover { color: var(--text); border-color: rgba(148,163,184,0.35); background: rgba(148,163,184,0.06); }

    /* ── ACTION BAR ── */
    .action-bar {
      display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
      margin-bottom: 24px;
      animation: fade-up 0.6s ease 0.05s both;
    }

    .btn-action {
      display: inline-flex; align-items: center; gap: 8px;
      padding: 10px 18px; border-radius: 12px;
      font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 500;
      cursor: pointer; text-decoration: none; border: none;
      transition: all 0.18s ease;
    }
    .btn-action i { font-size: 12px; }

    .btn-edit {
      background: rgba(56,189,248,0.1); border: 1px solid rgba(56,189,248,0.2); color: var(--blue);
    }
    .btn-edit:hover { background: rgba(56,189,248,0.2); transform: translateY(-2px); color: var(--blue); }

    .btn-toggle-on {
      background: rgba(250,204,21,0.1); border: 1px solid rgba(250,204,21,0.22); color: #fde047;
    }
    .btn-toggle-on:hover { background: rgba(250,204,21,0.2); transform: translateY(-2px); }

    .btn-toggle-off {
      background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.22); color: #4ade80;
    }
    .btn-toggle-off:hover { background: rgba(34,197,94,0.2); transform: translateY(-2px); }

    .btn-delete {
      background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.22); color: #f87171;
      margin-left: auto;
    }
    .btn-delete:hover { background: rgba(239,68,68,0.2); transform: translateY(-2px); }

    /* ── HERO ROW ── */
    .hero-row { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px; }

    /* ── GLASS CARD ── */
    .glass-card {
      background: var(--bg-card); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px);
      border: 1px solid var(--border); border-radius: 20px; overflow: hidden;
      box-shadow: 0 40px 80px rgba(0,0,0,0.5), inset 0 1px 0 rgba(56,189,248,0.08);
      animation: fade-up 0.6s ease both;
    }
    .glass-card:nth-child(1) { animation-delay: 0.1s; }
    .glass-card:nth-child(2) { animation-delay: 0.18s; }

    .card-inner { padding: 28px; }

    /* ── PPM CARD ── */
    .ppm-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; }
    .ppm-card { position: relative; }
    .ppm-card.normal::before  { background: linear-gradient(90deg, #22c55e, transparent); }
    .ppm-card.warning::before { background: linear-gradient(90deg, #facc15, transparent); }
    .ppm-card.danger::before  { background: linear-gradient(90deg, #ef4444, transparent); }

    .ppm-label { font-size: 10px; letter-spacing: 0.12em; text-transform: uppercase; color: var(--muted); margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }

    .ppm-value { font-family: 'Syne', sans-serif; font-size: 80px; font-weight: 800; line-height: 1; margin-bottom: 8px; }
    .ppm-value.normal  { color: #4ade80; }
    .ppm-value.warning { color: #fde047; }
    .ppm-value.danger  { color: #f87171; animation: pulse-val 2s ease-in-out infinite; }
    .ppm-unit { font-size: 20px; font-weight: 400; color: var(--muted); margin-left: 6px; }

    @keyframes pulse-val { 0%,100%{opacity:1} 50%{opacity:0.65} }

    .ppm-status { display: inline-flex; align-items: center; gap: 7px; font-size: 12px; padding: 6px 16px; border-radius: 100px; font-weight: 500; margin-top: 12px; }
    .status-normal  { background: rgba(34,197,94,0.1);  border: 1px solid rgba(34,197,94,0.25);  color: #4ade80; }
    .status-warning { background: rgba(250,204,21,0.1); border: 1px solid rgba(250,204,21,0.25); color: #fde047; }
    .status-danger  { background: rgba(239,68,68,0.1);  border: 1px solid rgba(239,68,68,0.25);  color: #f87171; }

    .pulse-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; animation: pulse-ring 2s ease-out infinite; }
    .pulse-dot.ok   { background: #22c55e; }
    .pulse-dot.warn { background: #facc15; }
    .pulse-dot.bad  { background: #ef4444; animation: none; }
    @keyframes pulse-ring { 0%{box-shadow:0 0 0 0 rgba(34,197,94,0.6)} 70%{box-shadow:0 0 0 8px rgba(34,197,94,0)} 100%{box-shadow:0 0 0 0 rgba(34,197,94,0)} }

    /* ── INFO CARD ── */
    .card-header-bar { padding: 18px 24px; border-bottom: 1px solid var(--border-s); background: linear-gradient(to right,rgba(56,189,248,0.03),transparent); position: relative; }
    .card-header-bar::before { content:''; position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,var(--blue),transparent); }
    .card-header-title { font-family:'Syne',sans-serif; font-size:14px; font-weight:700; color:var(--text); display:flex; align-items:center; gap:8px; }
    .card-header-title i { color:var(--blue); font-size:13px; }

    .info-list { display: flex; flex-direction: column; }
    .info-row { display: flex; align-items: center; justify-content: space-between; padding: 14px 24px; border-bottom: 1px solid var(--border-s); }
    .info-row:last-child { border-bottom: none; }
    .info-key { font-size: 11px; letter-spacing: 0.07em; text-transform: uppercase; color: var(--muted); display: flex; align-items: center; gap: 8px; }
    .info-key i { font-size: 11px; color: var(--blue); width: 14px; text-align: center; }
    .info-val { font-family: 'Syne', sans-serif; font-size: 13px; font-weight: 600; color: var(--text); text-transform: capitalize; }

    .badge-func { display: inline-flex; align-items: center; gap: 6px; font-size: 11px; padding: 5px 14px; border-radius: 100px; font-weight: 500; }
    .badge-activado      { background: rgba(34,197,94,0.1);  border: 1px solid rgba(34,197,94,0.25);  color: #4ade80; }
    .badge-apagado       { background: rgba(239,68,68,0.1);  border: 1px solid rgba(239,68,68,0.25);  color: #f87171; }
    .badge-mantenimiento { background: rgba(250,204,21,0.1); border: 1px solid rgba(250,204,21,0.25); color: #fde047; }

    /* ── CHART CARD ── */
    .chart-card { animation: fade-up 0.7s ease 0.28s both; }
    .chart-body { padding: 28px; }

    /* ── MODAL ── */
    .modal-overlay {
      position: fixed; inset: 0; z-index: 1000;
      background: rgba(0,0,0,0.7); backdrop-filter: blur(6px);
      display: flex; align-items: center; justify-content: center;
      opacity: 0; pointer-events: none; transition: opacity 0.2s ease;
    }
    .modal-overlay.open { opacity: 1; pointer-events: all; }

    .modal-box {
      background: rgba(8,13,28,0.98); border: 1px solid var(--border);
      border-radius: 20px; padding: 32px; width: 100%; max-width: 440px;
      box-shadow: 0 60px 120px rgba(0,0,0,0.8), inset 0 1px 0 rgba(56,189,248,0.1);
      transform: scale(0.94) translateY(10px); transition: transform 0.25s cubic-bezier(0.16,1,0.3,1);
      position: relative;
    }
    .modal-overlay.open .modal-box { transform: scale(1) translateY(0); }

    .modal-title { font-family: 'Syne', sans-serif; font-size: 18px; font-weight: 700; color: var(--text); margin-bottom: 6px; }
    .modal-sub { font-size: 13px; color: var(--muted); margin-bottom: 24px; }

    .modal-close {
      position: absolute; top: 16px; right: 16px;
      width: 30px; height: 30px; border-radius: 8px;
      background: rgba(255,255,255,0.05); border: 1px solid var(--border-s);
      color: var(--muted); font-size: 13px; cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      transition: all 0.15s;
    }
    .modal-close:hover { background: rgba(255,255,255,0.1); color: var(--text); }

    .form-label { font-size: 11px; letter-spacing: 0.07em; text-transform: uppercase; color: var(--muted); margin-bottom: 7px; display: block; }
    .form-input, .form-select-m {
      width: 100%; background: rgba(255,255,255,0.03); border: 1px solid var(--border-s);
      border-radius: 12px; padding: 12px 16px; font-family: 'DM Sans', sans-serif;
      font-size: 14px; color: var(--text); outline: none; margin-bottom: 16px;
      transition: border-color 0.18s, box-shadow 0.18s;
    }
    .form-input:focus, .form-select-m:focus { border-color: rgba(56,189,248,0.4); box-shadow: 0 0 0 3px rgba(56,189,248,0.08); }
    .form-select-m option { background: #0a1022; }

    .modal-actions { display: flex; gap: 10px; margin-top: 8px; }

    .btn-modal-cancel {
      flex: 1; padding: 12px; border-radius: 12px; cursor: pointer;
      background: transparent; border: 1px solid rgba(148,163,184,0.18);
      color: var(--muted); font-family: 'DM Sans', sans-serif; font-size: 14px;
      transition: all 0.18s;
    }
    .btn-modal-cancel:hover { border-color: rgba(148,163,184,0.35); color: var(--text); }

    .btn-modal-confirm {
      flex: 1; padding: 12px; border-radius: 12px; cursor: pointer; border: none;
      font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 500; color: #fff;
      background: linear-gradient(135deg, var(--blue), var(--blue-dk));
      box-shadow: 0 8px 24px rgba(14,165,233,0.25);
      transition: all 0.18s;
    }
    .btn-modal-confirm:hover { transform: translateY(-2px); box-shadow: 0 14px 32px rgba(14,165,233,0.38); }

    .btn-modal-delete {
      flex: 1; padding: 12px; border-radius: 12px; cursor: pointer; border: none;
      font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 500; color: #fff;
      background: linear-gradient(135deg, #ef4444, #dc2626);
      box-shadow: 0 8px 24px rgba(239,68,68,0.25);
      transition: all 0.18s;
    }
    .btn-modal-delete:hover { transform: translateY(-2px); }

    /* DELETE warning */
    .delete-warning {
      background: rgba(239,68,68,0.06); border: 1px solid rgba(239,68,68,0.2);
      border-radius: 12px; padding: 14px 16px; margin-bottom: 20px;
      font-size: 13px; color: #f87171; display: flex; align-items: center; gap: 10px;
    }

    /* ── ANIM ── */
    @keyframes fade-up { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:translateY(0)} }

    @media (max-width: 640px) {
      .hero-row { grid-template-columns: 1fr; }
      .ppm-value { font-size: 60px; }
      .page-wrap { padding: 24px 16px 50px; }
      .action-bar { gap: 8px; }
      .btn-delete { margin-left: 0; }
    }
  </style>
</head>
<body>

<?php
  // ─────────────────────────────
  // LÓGICA SIMPLE EN LA VISTA
  // ─────────────────────────────
  $ppm  = $sensor['valor_ppm'];
  $func = strtolower($sensor['funcionamiento']);

  if ($func === 'apagado') {
    $nivel = 'warning';
    $texto = 'Sensor apagado';
    $icono = 'fa-power-off';

  } elseif ($ppm < 50) {
    $nivel = 'normal';
    $texto = 'Nivel normal';
    $icono = 'fa-circle-check';

  } elseif ($ppm < 100) {
    $nivel = 'warning';
    $texto = 'Nivel moderado';
    $icono = 'fa-triangle-exclamation';

  } else {
    $nivel = 'danger';
    $texto = 'Nivel crítico';
    $icono = 'fa-circle-exclamation';
  }

  $dotClass = $nivel === 'normal'
      ? 'ok'
      : ($nivel === 'warning' ? 'warn' : 'bad');
?>

<canvas id="bg-canvas"></canvas>
<div class="grid-overlay"></div>
<div class="noise"></div>

<div class="page-wrap">

  <!-- HEADER -->
  <div class="page-header">
    <div class="header-left">
      <div class="brand-icon">
        <i class="fas fa-cloud-sun"></i>
      </div>

      <div>
        <div class="header-eyebrow">
          CO Monitor · Sensor #<?= str_pad($sensor['id'], 3, '0', STR_PAD_LEFT) ?>
        </div>

        <div class="header-title">
          <?= esc($sensor['sector']) ?>
        </div>
      </div>
    </div>

    <a href="<?= base_url('vistaprincipal') ?>" class="btn-back">
      <i class="fas fa-arrow-left"></i>
      Volver
    </a>
  </div>

  <!-- BOTONES -->
  <div class="action-bar">

    <!-- EDITAR -->
    <button class="btn-action btn-edit" onclick="openModal('edit')">
      <i class="fas fa-pen"></i>
      Editar sensor
    </button>

    <!-- ACTIVAR / APAGAR -->
    <?php if($func === 'activado'): ?>

      <a href="<?= base_url('sensor/apagar/' . $sensor['id']) ?>"
         class="btn-action btn-toggle-on">

        <i class="fas fa-power-off"></i>
        Apagar sensor
      </a>

    <?php else: ?>

      <a href="<?= base_url('sensor/activar/' . $sensor['id']) ?>"
         class="btn-action btn-toggle-off">

        <i class="fas fa-bolt"></i>
        Activar sensor
      </a>

    <?php endif; ?>

    <!-- CALIBRAR -->
    <button class="btn-action"
            style="background:rgba(168,85,247,0.1);
                   border:1px solid rgba(168,85,247,0.22);
                   color:#c084fc;"
            onclick="openModal('calibrar')">

      <i class="fas fa-sliders"></i>
      Calibrar
    </button>

    <!-- ELIMINAR -->
    <a href="<?= base_url('sensor/eliminar/' . $sensor['id']) ?>"
       class="btn-action btn-delete">

      <i class="fas fa-trash"></i>
      Eliminar
    </a>

  </div>

  <!-- CARDS -->
  <div class="hero-row">

    <!-- CARD PPM -->
    <div class="glass-card ppm-card <?= $nivel ?>">

      <div class="card-inner">

        <div class="ppm-label">
          <div class="pulse-dot <?= $dotClass ?>"></div>
          Nivel de CO en tiempo real
        </div>

        <div class="ppm-value <?= $nivel ?>">
          <?= esc($ppm) ?>
          <span class="ppm-unit">ppm</span>
        </div>

        <div class="ppm-status status-<?= $nivel ?>">
          <i class="fas <?= $icono ?>" style="font-size:10px;"></i>
          <?= $texto ?>
        </div>

      </div>
    </div>

    <!-- INFO -->
    <div class="glass-card">

      <div class="card-header-bar">
        <div class="card-header-title">
          <i class="fas fa-circle-info"></i>
          Información del sensor
        </div>
      </div>

      <div class="info-list">

        <div class="info-row">
          <span class="info-key">
            <i class="fas fa-hashtag"></i>
            ID
          </span>

          <span class="info-val">
            #<?= str_pad($sensor['id'], 3, '0', STR_PAD_LEFT) ?>
          </span>
        </div>

        <div class="info-row">
          <span class="info-key">
            <i class="fas fa-location-dot"></i>
            Sector
          </span>

          <span class="info-val">
            <?= esc($sensor['sector']) ?>
          </span>
        </div>

        <div class="info-row">
          <span class="info-key">
            <i class="fas fa-circle-half-stroke"></i>
            Estado
          </span>

          <span class="badge-func badge-<?= $func ?>">
            <?= ucfirst($func) ?>
          </span>
        </div>

        <div class="info-row">
          <span class="info-key">
            <i class="fas fa-gauge-high"></i>
            Valor PPM
          </span>

          <span class="info-val">
            <?= esc($ppm) ?> ppm
          </span>
        </div>

      </div>
    </div>

  </div>

  <!-- GRÁFICO -->
  <div class="glass-card chart-card">

    <div class="card-header-bar">
      <div class="card-header-title">
        <i class="fas fa-chart-area"></i>
        Historial simulado
      </div>
    </div>

    <div class="chart-body">
      <canvas id="chart" height="100"></canvas>
    </div>

  </div>

</div>

<!-- MODAL EDITAR -->
<div class="modal-overlay" id="modal-edit">

  <div class="modal-box">

    <button class="modal-close" onclick="closeModal('edit')">
      <i class="fas fa-xmark"></i>
    </button>

    <div class="modal-title">
      Editar Sensor
    </div>

    <form action="<?= base_url('sensor/editar/' . $sensor['id']) ?>" method="post">

      <label class="form-label">Sector</label>

      <input type="text"
             name="sector"
             class="form-input"
             value="<?= esc($sensor['sector']) ?>">

      <label class="form-label">Funcionamiento</label>

      <select name="funcionamiento" class="form-select-m">

        <option value="activado"
          <?= $func == 'activado' ? 'selected' : '' ?>>
          Activado
        </option>

        <option value="apagado"
          <?= $func == 'apagado' ? 'selected' : '' ?>>
          Apagado
        </option>

        <option value="mantenimiento"
          <?= $func == 'mantenimiento' ? 'selected' : '' ?>>
          Mantenimiento
        </option>

      </select>

      <label class="form-label">PPM</label>

      <input type="number"
             name="valor_ppm"
             class="form-input"
             value="<?= esc($ppm) ?>">

      <div class="modal-actions">

        <button type="button"
                class="btn-modal-cancel"
                onclick="closeModal('edit')">

          Cancelar
        </button>

        <button type="submit"
                class="btn-modal-confirm">

          Guardar
        </button>

      </div>

    </form>

  </div>

</div>

<script>
/* MODALES */
function openModal(id) {
  document
    .getElementById('modal-' + id)
    .classList.add('open');
}

function closeModal(id) {
  document
    .getElementById('modal-' + id)
    .classList.remove('open');
}

/* CHART */
const hours = [
  '00h','01h','02h','03h',
  '04h','05h','06h','07h',
  '08h','09h','10h','11h',
  'Ahora'
];

const base = <?= $ppm ?>;

const data = hours.map((_, i) =>
  Math.max(
    0,
    Math.round(
      base +
      (Math.random() - 0.5) * 20 -
      (hours.length - 1 - i) * 0.5
    )
  )
);

data[data.length - 1] = base;

new Chart(document.getElementById('chart'), {
  type: 'line',

  data: {
    labels: hours,

    datasets: [{
      label: 'CO (ppm)',
      data: data,
      borderColor: '#38bdf8',
      borderWidth: 2,
      tension: 0.4
    }]
  },

  options: {
    responsive: true
  }
});
</script>

</body>
</html>