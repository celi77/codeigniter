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
$routes->get('/home', 'Home::index'); 
$routes->get('vistaprincipal', 'VistaPrincipal::index');

// ================== REGISTRO STORE ==================
$routes->post('registro/store', 'Registro::store'); 

// ================== NUEVAS RUTAS - ESTADÍSTICAS (AGREGADAS AL FINAL) ==================

// Vista principal de Estadísticas
$routes->get('estadisticas', 'Estadisticas::index', ['as' => 'estadisticas']);

// (Opcional) Para filtrar en el futuro
$routes->get('estadisticas/filtrar', 'Estadisticas::filtrar', ['as' => 'estadisticas.filtrar']);


// ================== RUTA - ALERTAS ==================
$routes->get('alertas', 'Alertas::index');

// ================== RUTAS - MI PERFIL ==================
$routes->get('/miperfil', 'MiPerfil::miperfil');
$routes->post('/miperfil/guardar', 'MiPerfil::guardar');


// ================== RUTA - CONFIGURACIÓN ==================
$routes->get('configuracion', 'Configuracion::index');
// ================== RUTA - SENSORES (AGREGADA AL FINAL) ==================
$routes->get('sensores', 'Sensores::index');
// ================== RUTA - PLANO (AGREGADA AL FINAL) ==================

$routes->get('plano', function () {
    return view('plano');
});
$routes->get('/recuperar-password', 'RecuperarPassword::index');
$routes->post('/recuperar-password/enviar', 'RecuperarPassword::enviar');

$routes->get('recuperarpassword', 'RecuperarPassword::index');
$routes->post('recuperarpassword/enviar', 'RecuperarPassword::enviar');
$routes->get('recuperarpassword/cambiar/(:segment)', 'RecuperarPassword::cambiar/$1');
$routes->post('recuperarpassword/actualizar', 'RecuperarPassword::actualizar');

$routes->get('/admin/solicitudes', 'AdminRecuperacion::index');
$routes->get('/admin/aprobar/(:num)', 'AdminRecuperacion::aprobar/$1');
$routes->get('/admin/rechazar/(:num)', 'AdminRecuperacion::rechazar/$1');

//configuracion de roles admin
$routes->get('/configuracion', 'Configuracion::index');
$routes->post('/configuracion/actualizarRol', 'Configuracion::actualizarRol');

//nuevos sensores 
$routes->post('configuracion/guardarSensor', 'Configuracion::guardarSensor');


// ================== RUTA - SOLICITUD DE CONTRASEÑA (AGREGADA AL FINAL) ==================
$routes->get('sp', 'SolPass::index');
$routes->post('sp/send', 'SolPass::send');

$routes->get('sp/admin', 'SolPass::admin');
$routes->get('sp/aprobar/(:num)', 'SolPass::aprobar/$1');
$routes->get('sp/rechazar/(:num)', 'SolPass::rechazar/$1');




$routes->get('reset/(:any)', 'SolPass::reset/$1');

$routes->post('solpass/updatePassword', 'SolPass::updatePassword');