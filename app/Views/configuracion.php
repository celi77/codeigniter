<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Configuración</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body{
      background: linear-gradient(135deg, #070b14, #0b1220);
      color:#e5e7eb;
    }

    .glass{
      background: rgba(255,255,255,0.06);
      border:1px solid rgba(255,255,255,0.08);
      border-radius:20px;
      backdrop-filter: blur(14px);
      box-shadow: 0 10px 35px rgba(0,0,0,0.5);
    }

    .sidebar{
      min-height:100vh;
    }

    .nav-link{
      color:#cbd5e1;
      border-radius:12px;
      padding:12px;
      margin-bottom:8px;
      transition:0.2s;
    }

    .nav-link:hover{
      background: rgba(37,99,235,0.2);
      color:white;
    }

    .nav-link.active{
      background:#2563eb;
      color:white;
    }

    .section-title{
      font-size:1.5rem;
      font-weight:700;
      margin-bottom:20px;
    }

    .form-control, .form-select{
      background:#0b1220;
      border:1px solid rgba(255,255,255,0.1);
      color:#fff;
      border-radius:12px;
      padding:10px;
    }

    .form-control:focus, .form-select:focus{
      border-color:#2563eb;
      box-shadow:none;
    }

    .btn-primary{
      background:#2563eb;
      border:none;
      border-radius:12px;
      padding:10px;
      font-weight:600;
    }

    .btn-outline-light{
      border-radius:12px;
    }

    table{
      color:#e5e7eb;
    }
  </style>
</head>

<body>

<div class="container-fluid p-4">
  <div class="d-flex justify-content-between align-items-center mb-4">

    <h3 class="m-0"><i class="fas fa-gear me-2"></i> Configuración del Sistema</h3>

    <!-- BOTÓN VOLVER -->
    <a href="<?= base_url('vistaprincipal') ?>" class="btn btn-outline-light">
      <i class="fas fa-arrow-left me-2"></i> Volver
    </a>

  </div>

  <div class="row">

    <!-- SIDEBAR -->
    <div class="col-md-3">
      <div class="glass p-3">
        <div class="nav flex-column nav-pills">

          <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#usuarios">
            <i class="fas fa-users me-2"></i> Usuarios
          </button>

          <button class="nav-link" data-bs-toggle="pill" data-bs-target="#alertas">
            <i class="fas fa-bell me-2"></i> Alertas
          </button>


          <button class="nav-link" data-bs-toggle="pill" data-bs-target="#nuevo">
            <i class="fas fa-user-plus me-2"></i> Nuevo Usuario
          </button>

          <button class="nav-link" data-bs-toggle="pill" data-bs-target="#sensores">
  <i class="fas fa-microchip me-2"></i> Nuevo Sensor
</button>

        </div>
      </div>
    </div>

    <!-- CONTENT -->
    <div class="col-md-9">
      <div class="glass p-4">

        <div class="tab-content">

          <!-- USUARIOS -->
          <div class="tab-pane fade show active" id="usuarios">
            <div class="section-title">Gestión de Usuarios</div>

            <div class="table-responsive">
              <table class="table table-dark table-hover align-middle">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
               <tbody>
<?php foreach ($usuarios as $user): ?>
  <tr>
    <td><?= $user['id'] ?></td>
    <td><?= $user['nombre'] ?></td>
    <td><?= $user['email'] ?></td>

    <td>
      <form action="<?= base_url('configuracion/actualizarRol') ?>" method="post">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">

        <select name="rol" class="form-select form-select-sm">
          <option value="admin" <?= $user['rol'] == 'admin' ? 'selected' : '' ?>>
            Administrador
          </option>

          <option value="usuario" <?= $user['rol'] == 'usuario' ? 'selected' : '' ?>>
            Usuario
          </option>
        </select>
    </td>

    <td>
        <button type="submit" class="btn btn-sm btn-primary">
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

         <!-- ALERTAS -->
<div class="tab-pane fade" id="alertas">
  <div class="section-title">Configuración de Alertas</div>

  <div class="row g-3">

    <div class="col-md-6">
      <div class="glass p-3">
        <label class="form-label">Estado de alertas</label>
        <select class="form-select">
          <option>Activadas</option>
          <option>Desactivadas</option>
        </select>
      </div>
    </div>

    <div class="col-md-6">
      <div class="glass p-3">
        <label class="form-label">Tipo de notificación</label>
        <select class="form-select">
          <option>Email</option>
          <option>Sistema</option>
          <option>Ambas</option>
        </select>
      </div>
    </div>

    <div class="col-md-6">
      <div class="glass p-3">
        <label class="form-label">Umbral mínimo</label>
        <input type="number" class="form-control" placeholder="Ej: 10">
      </div>
    </div>

    <div class="col-md-6">
      <div class="glass p-3">
        <label class="form-label">Umbral máximo</label>
        <input type="number" class="form-control" placeholder="Ej: 80">
      </div>
    </div>

  </div>
</div>
          <!-- SISTEMA -->
          

          <!-- NUEVO USUARIO -->
          <div class="tab-pane fade" id="nuevo">
            <div class="section-title">Crear Nuevo Usuario</div>

            <form class="row g-3">

              <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" placeholder="Nombre completo">
              </div>

              <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" placeholder="correo@ejemplo.com">
              </div>

              <div class="col-md-6">
                <label class="form-label">Contraseña</label>
                <input type="password" class="form-control" placeholder="••••••••">
              </div>

              <div class="col-md-6">
                <label class="form-label">Rol</label>
                <select class="form-select">
                  <option>Administrador</option>
                  <option>Usuario</option>
                </select>
              </div>

              <div class="col-12">
                <button class="btn btn-primary w-100">
                  Crear usuario
                </button>
              </div>

            </form>
          </div>
           <!-- SENSORES -->
<div class="tab-pane fade" id="sensores">
  <div class="section-title">Agregar Nuevo Sensor</div>

  <form action="<?= base_url('configuracion/guardarSensor') ?>" method="post" class="row g-3">

 
    <div class="col-md-6">
      <label class="form-label">Sector</label>
      <input type="text" name="sector" class="form-control" placeholder="Ej: Cocina, Aula 3" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Funcionamiento</label>
      <select name="funcionamiento" class="form-select">
        <option value="activado">Activado</option>
        <option value="mantenimiento">En mantenimiento</option>
      </select>
    </div>

    

    <div class="col-12">
      <button type="submit" class="btn btn-primary w-100">
        <i class="fas fa-plus me-2"></i> Crear sensor
      </button>
    </div>

  </form>
</div>
          

        </div>

      </div>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>