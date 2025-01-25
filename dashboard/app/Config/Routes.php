<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/print', 'Report::index');
$routes->get('/printpdf', 'Home::generate');
$routes->get('/getData', 'Home::getData');
