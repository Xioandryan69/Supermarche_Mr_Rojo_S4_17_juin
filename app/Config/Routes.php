<?php

use CodeIgniter\Router\RouteCollection;
use app\Controllers\CaisseController;

use App\Controllers\Home;
use App\Controllers\AchatController;
/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/caisse', 'CaisseController::index');
$routes->post('caisse/valider', 'CaisseController::valider');
$routes->get('/achats', 'AchatController::listeProduit');
