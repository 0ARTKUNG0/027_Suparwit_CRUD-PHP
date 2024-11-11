<?php
// app/Config/Routes.php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setAutoRoute(true);

$routes->group('api', function($routes) {
    $routes->get('students', 'Api\Student::index');
    $routes->get('students/(:num)', 'Api\Student::show/$1');
    $routes->post('students', 'Api\Student::create');
    $routes->put('students/(:num)', 'Api\Student::update/$1');
    $routes->delete('students/(:num)', 'Api\Student::delete/$1');
});

$routes->options('(:any)', '', ['filter' => 'cors']);

$routes->set404Override(function() {
    return view('errors/404');
});