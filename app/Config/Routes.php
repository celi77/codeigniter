<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Inicio::index');
$routes->get('registro', 'Inicio::registro');
$routes->post('registro', 'Inicio::guardar');