<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ---------------------------------------------------------------
// Rutas simples
// ---------------------------------------------------------------
$routes->get('/', 'Auth::index');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::autenticar');
$routes->get('registro', 'Auth::registro');
$routes->post('registro', 'Auth::registrar');
$routes->get('logout', 'Auth::logout');

// ---------------------------------------------------------------
// Rutas para cualquier usuario  admin o cliente)
// ---------------------------------------------------------------
$routes->group('', ['filter' => 'auth'], static function (RouteCollection $routes) {
    $routes->get('home', 'Home::index');
    $routes->get('vehiculos', 'Vehiculos::index');
});

// ---------------------------------------------------------------
// Rutas exclusivas del rol Cliente
// ---------------------------------------------------------------
$routes->group('', ['filter' => 'cliente'], static function (RouteCollection $routes) {
    $routes->get('vehiculos/reservar/(:num)', 'Reservas::nueva/$1');
    $routes->post('reservas', 'Reservas::crear');
    $routes->get('mis-reservas', 'Reservas::misReservas');
});

// ---------------------------------------------------------------
// Rutas exclusivas del rol Administrador
// ---------------------------------------------------------------
$routes->group('admin', ['filter' => 'admin'], static function (RouteCollection $routes) {
    // Vehiculos: alta, modificacion, baja logica
    $routes->get('vehiculos', 'Vehiculos::adminIndex');
    $routes->get('vehiculos/nuevo', 'Vehiculos::nuevo');
    $routes->post('vehiculos', 'Vehiculos::crear');
    $routes->get('vehiculos/editar/(:num)', 'Vehiculos::editar/$1');
    $routes->post('vehiculos/actualizar/(:num)', 'Vehiculos::actualizar/$1');
    $routes->post('vehiculos/baja/(:num)', 'Vehiculos::baja/$1');
    $routes->post('vehiculos/alta/(:num)', 'Vehiculos::alta/$1');

    // Clientes: modificacion y baja logica
    $routes->get('clientes', 'Clientes::index');
    $routes->get('clientes/editar/(:num)', 'Clientes::editar/$1');
    $routes->post('clientes/actualizar/(:num)', 'Clientes::actualizar/$1');
    $routes->post('clientes/baja/(:num)', 'Clientes::baja/$1');
    $routes->post('clientes/alta/(:num)', 'Clientes::alta/$1');

    // Reservas: bandeja de pendientes, aprobar (alta de alquiler) o rechazar
    $routes->get('reservas', 'Reservas::pendientes');
    $routes->post('reservas/aprobar/(:num)', 'Reservas::aprobar/$1');
    $routes->post('reservas/rechazar/(:num)', 'Reservas::rechazar/$1');

    // Alquileres: vigentes, historial, busquedas y devolucion
    $routes->get('alquileres', 'Alquileres::actuales');
    $routes->get('alquileres/historial', 'Alquileres::historial');
    $routes->get('alquileres/por-vehiculo', 'Alquileres::porVehiculo');
    $routes->get('alquileres/por-cliente', 'Alquileres::porCliente');
    $routes->post('alquileres/devolver/(:num)', 'Alquileres::devolver/$1');
});
