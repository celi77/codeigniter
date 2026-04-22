<!DOCTYPE html>
<html>
<head>
    <title>Solicitudes</title>
</head>
<body>

<h2>Solicitudes de recuperación</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>Email</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>

    <?php foreach ($solicitudes as $s): ?>
        <tr>
            <td><?= $s['email'] ?></td>
            <td><?= $s['estado'] ?></td>
            <td>
                <a href="<?= base_url('admin/aprobar/'.$s['id']) ?>">Aprobar</a> |
                <a href="<?= base_url('admin/rechazar/'.$s['id']) ?>">Rechazar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>