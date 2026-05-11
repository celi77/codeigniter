<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Solicitud de Administrador</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

<div class="container mt-5">

  <h3>Solicitud de administrador</h3>
  <p>Envía tu solicitud para ser administrador del sistema.</p>

  <?php if(session()->getFlashdata('ok')): ?>
    <div class="alert alert-success">
      <?= session()->getFlashdata('ok') ?>
    </div>
  <?php endif; ?>

  <form method="post" action="<?= base_url('sp/enviar') ?>" class="mt-4">

    <div class="mb-3">
      <label>Nombre</label>
      <input type="text" class="form-control" value="<?= session()->get('nombre') ?>" disabled>
    </div>

    <div class="mb-3">
      <label>Email</label>
      <input type="email" class="form-control" value="<?= session()->get('email') ?>" disabled>
    </div>

    <div class="mb-3">
      <label>Motivo</label>
      <textarea name="motivo" class="form-control" required></textarea>
    </div>

    <button class="btn btn-primary">Enviar solicitud</button>

  </form>

</div>

</body>
</html>