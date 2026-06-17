<?php

use CodeIgniter\Router\RouteCollection;
/**
 * @var RouteCollection $routes
 */
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::attemptLogin');
$routes->get('/logout', 'AuthController::logout');

$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('/caisse', 'CaisseController::index');
    $routes->post('caisse/valider', 'CaisseController::valider');
});

$routes->group('', ['filter' => ['auth', 'caisse']], static function ($routes) {

    $routes->get('/dashboard', 'DashboardController::index');
    $routes->get('/dashboard/stock', 'DashboardController::stock');
    $routes->get('/dashboard/achats', 'DashboardController::achats');
    $routes->get('/dashboard/achats/(:num)', 'DashboardController::achatDetail/$1');

    $routes->get('/achats', 'AchatController::listeProduit');
    $routes->post('/achat/verifier-stock', 'AchatController::verifierStock');
    $routes->post('/achat/valider', 'AchatController::validerAchats');
});
