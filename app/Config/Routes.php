<?php namespace Config;

use App\Filters\AuthFilter;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->post('/auth/login', 'Auth::login');

$routes->group('api', ['namespace' => 'App\Controllers\API', 'filter' => 'authFilter'], function ($routes) {
	//RUTAS REGISTRO DE ROLES
	$routes->get('roles', 'Roles::index');
	$routes->post('roles/create', 'Roles::create');
	$routes->delete('roles/delete/(:num)', 'Roles::delete/$1');


	//RUTAS REGISTRO DE USUARIOS
	$routes->get('usuarios', 'Usuarios::index');
	$routes->post('usuarios/create', 'Usuarios::create');
	$routes->delete('usuarios/delete/(:num)', 'Usuarios::delete/$1');

	//rutas para docentes/profesores
	$routes->get('profesores', 'Profesores::index');
	$routes->post('profesores/create', 'Profesores::create');
	$routes->get('profesores/edit/(:num)', 'Profesores::edit/$1');
	$routes->put('profesores/update/(:num)', 'Profesores::update/$1');
	$routes->delete('profesores/delete/(:num)', 'Profesores::delete/$1');


	//rutas para Grados
	$routes->get('grados', 'Grados::index');
	$routes->post('grados/create', 'Grados::create');
	$routes->get('grados/edit/(:num)', 'Grados::edit/$1');
	$routes->put('grados/update/(:num)', 'Grados::update/$1');
	$routes->delete('grados/delete/(:num)', 'Grados::delete/$1');
	$routes->get('grados/show/(:num)', 'Grados::show/$1');

	//rutas para Estudiantes
	$routes->get('estudiantes', 'Estudiantes::index');
	$routes->post('estudiantes/create', 'Estudiantes::create');
	$routes->get('estudiantes/edit/(:num)', 'Estudiantes::edit/$1');
	$routes->put('estudiantes/update/(:num)', 'Estudiantes::update/$1');
	$routes->delete('estudiantes/delete/(:num)', 'Estudiantes::delete/$1');

	//rutas para Estudiantes
	$routes->get('estudiantes', 'Estudiantes::index');
	$routes->post('estudiantes/create', 'Estudiantes::create');
	$routes->get('estudiantes/edit/(:num)', 'Estudiantes::edit/$1');
	$routes->put('estudiantes/update/(:num)', 'Estudiantes::update/$1');
	$routes->delete('estudiantes/delete/(:num)', 'Estudiantes::delete/$1');
});

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
