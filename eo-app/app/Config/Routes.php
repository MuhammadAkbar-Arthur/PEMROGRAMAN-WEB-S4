<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- PUBLIC ROUTES (GUEST & ALL ROLES) ---
$routes->get('/', 'Home::index');
$routes->get('/search-event', 'Home::search');
$routes->get('/event/(:num)', 'Home::detail/$1');
$routes->get('/test-email', 'TestMail::index'); 

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
    $routes->post('/booking/delete/(:num)', 'Booking::delete/$1');
    
    // APPROVE & REJECT BOOKING (Dipindah ke sini agar bisa diakses Admin & Organizer dengan aman)
    $routes->get('/booking/approve/(:num)', 'Booking::approve/$1');
    $routes->get('/booking/reject/(:num)', 'Booking::reject/$1');

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

// --- ORGANIZER ONLY ---
$routes->group('organizer', ['filter' => 'organizer'], function($routes) {
    $routes->get('/', 'Organizer::index');
    $routes->get('bookings', 'Organizer::bookings');
    // Rute approve/reject dihapus dari sini karena sudah dipindah ke global booking di atas
    $routes->get('my-events', 'Organizer::myEvents');
});

// --- ADMIN ONLY ---
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('/', 'Admin::index');
    $routes->get('export', 'Admin::exportCSV');
    $routes->get('analytics', 'Admin::analytics');

    // Category Management
    $routes->get('categories', 'Category::index');
    $routes->post('categories/store', 'Category::store');
    $routes->post('categories/update/(:num)', 'Category::update/$1'); 
    $routes->get('categories/delete/(:num)', 'Category::delete/$1');

    // User Management
    $routes->get('users', 'Admin::users');
    $routes->get('users/make-organizer/(:num)', 'Admin::makeOrganizer/$1');
    $routes->get('users/make-user/(:num)', 'Admin::makeUser/$1');
    $routes->get('users/delete/(:num)', 'Admin::deleteUser/$1'); 
    
    // Event Management (Global Admin Moderation)
    $routes->get('events/delete/(:num)', 'Admin::deleteEvent/$1'); 
});

// --- EVENT MANAGEMENT ---
$routes->group('event', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Event::index');
    $routes->get('create', 'Event::create');
    $routes->post('store', 'Event::store');
    $routes->get('edit/(:num)', 'Event::edit/$1');
    $routes->post('update/(:num)', 'Event::update/$1');
    $routes->get('delete/(:num)', 'Event::delete/$1');
});