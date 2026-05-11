<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ================== INICIO Y AUTENTICACIÓN ==================
$routes->get('/', 'Inicio::index');

$routes->get('registro', 'Inicio::registro');
$routes->post('registro', 'Inicio::guardar');

$routes->get('registro', 'Registro::index');

$routes->get('login', 'Login::index');
$routes->post('login/validate', 'Login::validate');
$routes->get('login/logout', 'Login::logout');

$routes->post('login/checkLogin', 'Login::checkLogin');


// ================== PANEL Y VISTAS PRINCIPALES ==================
$routes->get('panelusuario', 'PanelUsuario::index');
$routes->get('home', 'Home::index');
$routes->get('vistaprincipal', 'VistaPrincipal::index');


// ================== REGISTRO STORE ==================
$routes->post('registro/store', 'Registro::store');


// ================== ESTADÍSTICAS ==================
$routes->get('estadisticas', 'Estadisticas::index', ['as' => 'estadisticas']);
$routes->get('estadisticas/filtrar', 'Estadisticas::filtrar', ['as' => 'estadisticas.filtrar']);


// ================== ALERTAS ==================
$routes->get('alertas', 'Alertas::index');


// ================== PERFIL ==================
$routes->get('miperfil', 'MiPerfil::miperfil');
$routes->post('miperfil/guardar', 'MiPerfil::guardar');


// ================== CONFIGURACIÓN ==================
$routes->get('configuracion', 'Configuracion::index');
$routes->post('configuracion/actualizarRol', 'Configuracion::actualizarRol');
$routes->post('configuracion/guardarSensor', 'Configuracion::guardarSensor');
$routes->post('configuracion/crearUsuario', 'Configuracion::crearUsuario');


// ================== SENSORES ==================
$routes->get('sensores', 'Sensores::index');

$routes->get('sensor/(:num)', 'SensorController::ver/$1');
$routes->post('sensor/editar/(:num)', 'SensorController::editar/$1');
$routes->get('sensor/apagar/(:num)', 'SensorController::apagar/$1');
$routes->get('sensor/activar/(:num)', 'SensorController::activar/$1');
$routes->post('sensor/calibrar/(:num)', 'SensorController::calibrar/$1');
$routes->get('sensor/eliminar/(:num)', 'SensorController::eliminar/$1');


// ================== PLANO ==================
$routes->get('plano', function () {
    return view('plano');
});
$routes->get('plano', 'Plano::index');


// ================== LOGIN / CAMBIO DE CONTRASEÑA (ARREGLADO) ==================
$routes->get('cambiar-password', 'Login::cambiarPassword');
$routes->post('cambiar-password/actualizar', 'Login::actualizarPassword');

// ================== ADMIN RECUPERACIÓN ==================
$routes->get('admin/solicitudes', 'AdminRecuperacion::index');
$routes->get('admin/aprobar/(:num)', 'AdminRecuperacion::aprobar/$1');
$routes->get('admin/rechazar/(:num)', 'AdminRecuperacion::rechazar/$1');


// ================== SOLPASS ==================
$routes->get('sp', 'SolPass::index');
$routes->post('sp/send', 'SolPass::send');

$routes->get('sp/admin', 'SolPass::admin');
$routes->get('sp/aprobar/(:num)', 'SolPass::aprobar/$1');
$routes->get('sp/rechazar/(:num)', 'SolPass::rechazar/$1');

$routes->get('reset/(:any)', 'SolPass::reset/$1');
$routes->post('solpass/updatePassword', 'SolPass::updatePassword');


// ================== LOGOUT GENERAL ==================
$routes->get('logout', 'VistaPrincipal::logout');

// ================== SOLICITUD ADMIN ==================
$routes->get('sp/solicitar', 'SolicitudAdmin::index');
$routes->post('sp/enviar', 'SolicitudAdmin::enviar');