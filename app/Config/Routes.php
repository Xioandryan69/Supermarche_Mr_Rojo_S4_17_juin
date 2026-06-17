<?php

use CodeIgniter\Router\RouteCollection;
use app\Controllers\CaisseController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/achats', 'Home::index');
$routes->get('/caisse', 'CaisseController::index');
$routes->post('caisse/valider', 'CaisseController::valider');
