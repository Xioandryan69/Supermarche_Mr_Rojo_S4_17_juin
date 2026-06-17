<?php

use CodeIgniter\Router\RouteCollection;
<<<<<<< HEAD
use app\Controllers\CaisseController;

=======
use App\Controllers\Home;
use App\Controllers\AchatController;
>>>>>>> 49a0f6ef3eda6f388406778c16549f0b0c9043de
/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
<<<<<<< HEAD
$routes->get('/achats', 'Home::index');
$routes->get('/caisse', 'CaisseController::index');
$routes->post('caisse/valider', 'CaisseController::valider');
=======
//$routes->get('/achats','Home::index');
$routes->get('/achats','AchatController::liste');
>>>>>>> 49a0f6ef3eda6f388406778c16549f0b0c9043de
