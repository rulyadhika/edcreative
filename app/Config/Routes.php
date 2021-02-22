<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
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
$routes->get('/pencarian/', 'Home::search');
$routes->get('/kategori/(:segment)', 'Home::kategori/$1');
$routes->get('/read/(:segment)', 'Home::detail/$1');

// routes for admin page
$routes->group('admin', ['filter' => 'role:admin,superadmin,dev'], function ($routes) {
	$routes->get('dashboard', 'Admin\Dashboard::index');
	$routes->get('postingan', 'Admin\Postingan::index');
	$routes->get('postingan/add', 'Admin\Postingan::add');
	$routes->get('postingan/edit/(:any)', 'Admin\Postingan::edit/$1');

	$routes->get('kategori', 'Admin\Kategori::index');
});
$routes->get('admin/user', 'Admin\User::index', ['filter' => 'role:superadmin,dev']);

$routes->post('/admin/postingan/update', 'Admin\Postingan::update');
$routes->delete('/admin/postingan/delete/(:segment)', 'Admin\Postingan::delete/$1');
$routes->addRedirect('/admin/postingan/delete/(:any)', 'admin/postingan');

$routes->post('/admin/kategori/insert', 'Admin\Kategori::insert');
$routes->delete('/admin/kategori/delete/(:num)', 'Admin\Kategori::delete/$1');
$routes->addRedirect('/admin/kategori/delete/(:any)', 'admin/kategori');



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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
