<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Solicitudes</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #0f172a, #1e2937);
    min-height: 100vh;
    font-family: 'Segoe UI', sans-serif;
    color: white;
}

.container {
    max-width: 900px;
}

.card-custom {
    background: rgba(15, 23, 42, 0.95);
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.6);
    border: 1px solid rgba(56,189,248,0.2);
}

.btn-back {
    margin-bottom: 20px;
    display: inline-block;
    text-decoration: none;
    color: #94a3b8;
}

.btn-back:hover {
    color: white;
}

.table {
    background: transparent;
}

.table thead {
    color: #cbd5e1;
}

.btn-success {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    border: none;
}

.btn-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border: none;
}

.alert {
    background: rgba(251, 191, 36, 0.1);
    border: 1px solid rgba(251, 191, 36, 0.3);
    color: #facc15;
}
</style>
</head>

<body>

<div class="container mt-5">

    <!-- 🔙 VOLVER -->
    <a href="<?= base_url('vistaprincipal') ?>" class="btn-back">← Volver</a>

    <div class="card-custom">
        <h4 class="mb-3">Solicitudes</h4>

        <?php if(isset($solicitudes) && count($solicitudes) > 0): ?>

        <div class="table-responsive">
        <table class="table table-dark table-borderless align-middle">
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
                <tr>
                    <td><?= $s['id'] ?></td>
                    <td><?= $s['email'] ?></td>

                    <td>
                        <?php if($s['estado'] == 'pendiente'): ?>
                            <span class="text-warning">Pendiente</span>
                        <?php elseif($s['estado'] == 'aprobado'): ?>
                            <span class="text-success">Aprobado</span>
                        <?php elseif($s['estado'] == 'rechazado'): ?>
                            <span class="text-danger">Rechazado</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if(session()->get('rol') === 'admin' && $s['estado'] == 'pendiente'): ?>
                            <a href="<?= base_url('sp/aprobar/'.$s['id']) ?>" class="btn btn-success btn-sm">Aprobar</a>
                            <a href="<?= base_url('sp/rechazar/'.$s['id']) ?>" class="btn btn-danger btn-sm">Rechazar</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>

        <?php else: ?>

        <div class="alert mt-3">
            No hay solicitudes
        </div>

        <?php endif; ?>

    </div>

</div>

</body>
</html>
