<?php
function nivel($ppm){
    if($ppm >= 150) return ['Crítico', 'card-critical'];
    if($ppm >= 50) return ['Advertencia', 'card-warning'];
    return ['Normal', 'card-normal'];
}

$dorm = nivel($dormitorio);
$gara = nivel($garaje);
$coci = nivel($cocina);

$critico = ($dormitorio >= 150 || $garaje >= 150 || $cocina >= 150);

/* =========================
   ALERTAS DEL SISTEMA
========================= */
function generarMensaje($zona, $ppm){
    if($ppm >= 150){
        return "ALERTA CRÍTICA: $zona detectó nivel alto ($ppm ppm)";
    }
    if($ppm >= 50){
        return "Advertencia: $zona con nivel elevado ($ppm ppm)";
    }
    return "Normal: $zona sin riesgos ($ppm ppm)";
}

$alertas = [
    generarMensaje("Dormitorio", $dormitorio),
    generarMensaje("Garaje", $garaje),
    generarMensaje("Cocina", $cocina),
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Alertas - Sistema CO</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>

*{margin:0;padding:0;box-sizing:border-box;}

body{
    background: linear-gradient(135deg,#0f172a,#1e293b);
    font-family: 'Inter', sans-serif;
    color:white;
    padding:40px;
}

.container{
    max-width:1200px;
    margin:auto;
}

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:40px;
}

h1{
    font-size:30px;
    font-weight:700;
    color:#38bdf8;
}

.btn{
    background:#1e293b;
    padding:10px 18px;
    border-radius:10px;
    text-decoration:none;
    color:#94a3b8;
    border:1px solid rgba(148,163,184,0.2);
    transition:0.3s;
}

.btn:hover{
    background:#334155;
    color:white;
}

.grid{
    display:grid;
    grid-template-columns: repeat(auto-fit,minmax(280px,1fr));
    gap:25px;
}

.card{
    background:#1e293b;
    padding:30px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.4);
    border:1px solid rgba(56,189,248,0.1);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.card h3{
    margin-bottom:15px;
    font-size:18px;
    color:#94a3b8;
}

.ppm{
    font-size:32px;
    font-weight:700;
    margin-bottom:10px;
}

.estado{
    font-size:14px;
    padding:6px 12px;
    border-radius:20px;
    display:inline-block;
}

/* estados suaves */
.card-normal .estado{
    background:rgba(34,197,94,0.15);
    color:#22c55e;
}

.card-warning .estado{
    background:rgba(250,204,21,0.15);
    color:#facc15;
}

.card-critical .estado{
    background:rgba(239,68,68,0.15);
    color:#ef4444;
}

.general{
    margin-top:50px;
    background:#1e293b;
    padding:40px;
    border-radius:25px;
    text-align:center;
    border:1px solid rgba(56,189,248,0.1);
}

.general h2{
    margin-bottom:20px;
    color:#94a3b8;
}

.general .valor{
    font-size:34px;
    font-weight:700;
    color: <?= $critico ? '#ef4444' : '#22c55e' ?>;
}

/* ALERTAS LOG */
.log{
    margin-top:40px;
    text-align:left;
}

.log-item{
    background:#0f172a;
    padding:12px 15px;
    margin-bottom:10px;
    border-left:4px solid #38bdf8;
    border-radius:10px;
    font-size:14px;
    color:#cbd5e1;
}

</style>
</head>

<body>

<div class="container">

<div class="header">
    <h1>Centro de Alertas</h1>
    <a href="<?= base_url('vistaprincipal') ?>" class="btn">Volver</a>
</div>

<div class="grid">

<div class="card <?= $dorm[1] ?>">
    <h3>Dormitorio</h3>
    <div class="ppm"><?= $dormitorio ?> ppm</div>
    <div class="estado"><?= $dorm[0] ?></div>
</div>

<div class="card <?= $gara[1] ?>">
    <h3>Garaje</h3>
    <div class="ppm"><?= $garaje ?> ppm</div>
    <div class="estado"><?= $gara[0] ?></div>
</div>

<div class="card <?= $coci[1] ?>">
    <h3>Cocina</h3>
    <div class="ppm"><?= $cocina ?> ppm</div>
    <div class="estado"><?= $coci[0] ?></div>
</div>

</div>

<div class="general">
    <h2>Estado General del Sistema</h2>
    <div class="valor">
        <?= $critico ? "SISTEMA EN ALERTA" : "SISTEMA OPERANDO NORMALMENTE" ?>
    </div>
</div>

<!-- 🔔 LOG DE ALERTAS -->
<div class="general log">
    <h2>Registro de Eventos del Sistema</h2>

    <?php foreach($alertas as $a): ?>
        <div class="log-item">
            <?= $a ?>
        </div>
    <?php endforeach; ?>

</div>

</div>

</body>
</html>