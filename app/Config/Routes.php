<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default home → users list
$routes->get('/', 'Users::index');

// Users resource routes
$routes->get('users',              'Users::index');
$routes->get('users/create',       'Users::create');
$routes->post('users/store',       'Users::store');
$routes->get('users/(:num)',       'Users::show/$1');
$routes->post('users/delete/(:num)', 'Users::delete/$1');
