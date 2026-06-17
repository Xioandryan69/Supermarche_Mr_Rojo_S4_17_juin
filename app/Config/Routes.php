<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\CaisseController;
use App\Controllers\Home;
use App\Controllers\AchatController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
/**
 * @var RouteCollection $routes
 */

$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::doLogin');
$routes->get('/logout', 'AuthController::logout', ['filter' => 'auth']);

// Routes protégées par authentification
$routes->get('/', 'Home::index', ['filter' => 'auth']);
$routes->get('/caisse', 'CaisseController::index', ['filter' => 'auth']);
$routes->post('caisse/valider', 'CaisseController::valider', ['filter' => 'auth']);
$routes->get('/achats', 'AchatController::listeProduit', ['filter' => 'auth']);
$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'auth']);

