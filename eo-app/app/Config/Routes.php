<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- PUBLIC ROUTES (GUEST & ALL ROLES) ---
$routes->get('/', 'Home::index');
$routes->get('/search-event', 'Home::search');
$routes->get('/event/(:num)', 'Home::detail/$1');
$routes->get('/test-email', 'TestMail::index'); // Rute testing email

// --- AUTHENTICATION ---
$routes->get('/login', 'Auth::login');
$routes->post('/login/process', 'Auth::processLogin');
$routes->get('/register', 'Auth::register');
$routes->post('/register/process', 'Auth::processRegister');
$routes->get('/logout', 'Auth::logout');

// --- REGISTERED USER ONLY (Harus Login: 'auth') ---
$routes->group('', ['filter' => 'auth'], function($routes) {
    
    // DASHBOARD & PROFILE
    $routes->get('/user', 'Dashboard::user');
    $routes->get('/dashboard', 'Dashboard::index');
    $routes->get('/profile', 'Profile::index');
    $routes->post('/profile/update', 'Profile::update');

    // BOOKING SYSTEM
    $routes->get('/book/(:num)', 'Booking::create/$1');
    $routes->get('/my-bookings', 'Booking::myBookings');
    $routes->get('/booking/delete/(:num)', 'Booking::delete/$1');
    $routes->get('/ticket/(:num)', 'Booking::ticket/$1');
    $routes->get('/ticket/verify/(:num)', 'Booking::verify/$1');

    // WISHLIST / FAVORITE
    $routes->get('/favorite', 'Favorite::index');
    $routes->get('/favorite/add/(:num)', 'Favorite::add/$1');
    $routes->get('/favorite/remove/(:num)', 'Favorite::remove/$1');

    // COMMENTS SYSTEM
    $routes->post('/comment/store/(:num)', 'Comment::store/$1');
    $routes->get('/comment/delete/(:num)', 'Comment::delete/$1');
});

// --- ORGANIZER ONLY (Harus Hak Akses Organizer: 'organizer') ---
$routes->group('organizer', ['filter' => 'organizer'], function($routes) {
    $routes->get('/', 'Organizer::index');
    $routes->get('bookings', 'Organizer::bookings');
    $routes->get('booking/approve/(:num)', 'Organizer::approveBooking/$1');
    $routes->get('booking/reject/(:num)', 'Organizer::rejectBooking/$1');
});

// --- ADMIN ONLY (Harus Hak Akses Admin: 'admin') ---
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    // Dashboard Admin
    $routes->get('/', 'Admin::index');
    $routes->get('export', 'Admin::exportCSV');
    
    // Managemen Approval Global via Admin (Jika diperlukan)
    $routes->get('booking/approve/(:num)', 'Booking::approve/$1');
    $routes->get('booking/reject/(:num)', 'Booking::reject/$1');
});

$routes->group('event', ['filter' => 'admin'], function($routes) {
    $routes->get('/', 'Event::index');
    $routes->get('create', 'Event::create');
    $routes->post('store', 'Event::store');
    $routes->get('edit/(:num)', 'Event::edit/$1');
    $routes->post('update/(:num)', 'Event::update/$1');
    $routes->get('delete/(:num)', 'Event::delete/$1');
});