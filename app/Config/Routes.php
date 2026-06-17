<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Home;
use App\Controllers\AchatController;
/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
//$routes->get('/achats','Home::index');
$routes->get('/achats','AchatController::liste');
