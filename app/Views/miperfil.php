<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $titulo ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body { background: linear-gradient(135deg, #0f172a 0%, #1e2937 100%); color: #e2e8f0; font-family: 'Segoe UI', system-ui, sans-serif; }
    .card { background: rgba(15, 23, 42, 0.95); border: 1px solid #334155; }
    .input-focus { transition: all 0.3s; }
    .input-focus:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3); }
  </style>
</head>

<body class="min-h-screen py-8">

<div class="max-w-3xl mx-auto px-4">

  <!-- Header -->
  <div class="flex items-center justify-between mb-8">
    <div class="flex items-center gap-3">
      <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center">
        <i class="fas fa-cloud-sun text-white text-2xl"></i>
      </div>
      <div>
        <h1 class="text-2xl font-bold text-white">Monitoreo Inteligente de CO</h1>
        <p class="text-slate-400 text-sm">Configuración de Perfil</p>
      </div>
    </div>
    <button onclick="window.history.back()" class="text-slate-400 hover:text-white transition-colors">
      <i class="fas fa-arrow-left"></i> Volver
    </button>
  </div>

  <!-- Mensaje flash -->
  <?php if(session()->getFlashdata('mensaje')): ?>
    <div class="mb-4 p-4 rounded-xl bg-green-600 text-white">
      <?= session()->getFlashdata('mensaje') ?>
    </div>
  <?php endif; ?>

  <div class="card rounded-3xl shadow-2xl p-8">

    <!-- FORM AHORA CON ENCTYPE -->
    <form action="<?= base_url('miperfil/guardar') ?>" method="post" enctype="multipart/form-data" class="space-y-6">

      <div class="flex flex-col items-center mb-10">

        <!-- FOTO DE PERFIL -->
        <div class="relative">

          <div class="w-28 h-28 bg-slate-700 rounded-2xl overflow-hidden border-4 border-blue-500">
            <img src="<?= isset($foto) && $foto 
                ? base_url('uploads/perfil/'.$foto) 
                : 'https://via.placeholder.com/200?text=Perfil' ?>"
              alt="Foto de perfil"
              class="w-full h-full object-cover">
          </div>

          <!-- INPUT FILE -->
          <label class="absolute bottom-1 right-1 bg-blue-600 hover:bg-blue-700 w-8 h-8 rounded-full flex items-center justify-center border-2 border-slate-900 cursor-pointer">
            <i class="fas fa-camera text-sm"></i>
            <input type="file" name="foto" accept="image/*" class="hidden">
          </label>

        </div>

        <h2 class="mt-4 text-xl font-semibold"><?= $usuario ?></h2>
        <p class="text-slate-400 text-sm"><?= $email ?></p>
      </div>

      <!-- Formulario -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium text-slate-300 mb-2">Nombre completo</label>
          <input type="text" name="nombre" value="<?= $nombre ?>" class="input-focus w-full bg-slate-800 border border-slate-600 rounded-xl px-4 py-3 focus:outline-none text-white">
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-300 mb-2">Nombre de usuario</label>
          <input type="text" name="usuario" value="<?= $usuario ?>" class="input-focus w-full bg-slate-800 border border-slate-600 rounded-xl px-4 py-3 focus:outline-none text-white">
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-slate-300 mb-2">Correo electrónico</label>
        <input type="email" name="email" value="<?= $email ?>" class="input-focus w-full bg-slate-800 border border-slate-600 rounded-xl px-4 py-3 focus:outline-none text-white">
      </div>

      <!-- Notificaciones -->
      <div class="pt-4 border-t border-slate-700">
        <h3 class="text-lg font-semibold mb-4 text-blue-400">Preferencias de Notificaciones</h3>

        <div class="space-y-4">

          <div class="flex items-center justify-between bg-slate-800/50 p-4 rounded-2xl">
            <div>
              <p class="font-medium">Alertas de alto CO</p>
              <p class="text-xs text-slate-400">Notificaciones cuando se detecte niveles peligrosos</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
              <input type="checkbox" checked class="sr-only peer" name="alertas_co">
              <div class="w-11 h-6 bg-slate-600 peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 peer-checked:bg-blue-600"></div>
            </label>
          </div>

          <div class="flex items-center justify-between bg-slate-800/50 p-4 rounded-2xl">
            <div>
              <p class="font-medium">Reportes diarios</p>
              <p class="text-xs text-slate-400">Resumen diario por email</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
              <input type="checkbox" checked class="sr-only peer" name="reportes_diarios">
              <div class="w-11 h-6 bg-slate-600 peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 peer-checked:bg-blue-600"></div>
            </label>
          </div>

        </div>
      </div>

      <!-- Botón -->
      <div class="flex gap-4 pt-6">
        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-500 transition-colors py-4 rounded-2xl font-medium flex items-center justify-center gap-2">
          <i class="fas fa-save"></i> Guardar Cambios
        </button>
      </div>

    </form>

  </div>

  <div class="text-center text-slate-500 text-xs mt-8">
    Sistema Inteligente de Monitoreo de Monóxido de Carbono © 2026
  </div>

</div>

</body>
</html>