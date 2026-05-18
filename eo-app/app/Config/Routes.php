<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

// AUTH
$routes->get('/login', 'Auth::login');
$routes->post('/login/process', 'Auth::processLogin');

$routes->get('/register', 'Auth::register');
$routes->post('/register/process', 'Auth::processRegister');

$routes->get('/logout', 'Auth::logout');

// DASHBOARD
$routes->get('/user', 'Dashboard::user');
// ADMIN
$routes->get('/admin', 'Admin::index', ['filter' => 'admin']);
$routes->get('/admin/export', 'Admin::exportCSV', ['filter' => 'admin']);

// PROFILE
$routes->get('/profile', 'Profile::index');
$routes->post('/profile/update', 'Profile::update');

// EVENT (ADMIN ONLY)

$routes->get('/event', 'Event::index', ['filter' => 'admin']);

$routes->get('/event/create', 'Event::create', ['filter' => 'admin']);

$routes->post('/event/store', 'Event::store', ['filter' => 'admin']);

$routes->get('/event/edit/(:num)', 'Event::edit/$1', ['filter' => 'admin']);

$routes->post('/event/update/(:num)', 'Event::update/$1', ['filter' => 'admin']);

$routes->get('/event/delete/(:num)', 'Event::delete/$1', ['filter' => 'admin']);

// EVENT PUBLIC
$routes->get('/event/(:num)', 'Home::detail/$1');

// BOOKING
$routes->get('/book/(:num)', 'Booking::create/$1');

$routes->get('/my-bookings', 'Booking::myBookings');

$routes->get('/booking/delete/(:num)', 'Booking::delete/$1');

$routes->get('/ticket/(:num)', 'Booking::ticket/$1');

// FAVORITE / WISHLIST
$routes->get('/favorite', 'Favorite::index');

$routes->get('/favorite/add/(:num)', 'Favorite::add/$1');

$routes->get('/favorite/remove/(:num)', 'Favorite::remove/$1');

$routes->get('/dashboard', 'Dashboard::index');

$routes->get('/booking/approve/(:num)', 'Booking::approve/$1');

$routes->get('/booking/reject/(:num)', 'Booking::reject/$1');
//
$routes->get('/search-event', 'Home::search');

// COMMENTS
$routes->post('/comment/store/(:num)', 'Comment::store/$1');

$routes->get('/comment/delete/(:num)', 'Comment::delete/$1');

//email
$routes->get('/test-email', 'TestMail::index');

$routes->get(
    '/ticket/verify/(:num)',
    'Booking::verify/$1'
);