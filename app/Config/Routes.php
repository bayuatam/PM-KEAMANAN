<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// === RUTE PUBLIK (TIDAK PERLU LOGIN) ===
$routes->get('/', 'HomeController::index');
$routes->get('/products', 'ProductController::index');
$routes->get('/products/category/(:num)', 'ProductController::category/$1');
$routes->get('/product/(:num)', 'ProductController::detail/$1');
$routes->get('/about', 'AboutController::index');

// Rute Keranjang
$routes->get('/cart', 'CartController::index');
$routes->get('/cart/add/(:num)', 'CartController::add/$1');
$routes->post('/cart/update', 'CartController::update');
$routes->get('/cart/remove/(:num)', 'CartController::remove/$1');
$routes->get('/cart/clear', 'CartController::clear');

// Rute Checkout & Pembayaran
$routes->get('/checkout', 'CheckoutController::index');
$routes->post('/checkout/process', 'CheckoutController::process');
$routes->get('/checkout/payment/(:num)', 'CheckoutController::payment/$1'); // DIPINDAHKAN KE SINI
$routes->get('/checkout/success/(:num)', 'CheckoutController::success/$1');

// RUTE BARU UNTUK WEBHOOK MIDTRANS
$routes->post('/payment/notification', 'CheckoutController::notificationHandler');

// Rute Lacak Pesanan
$routes->get('/track', 'TrackOrderController::index'); // DIPINDAHKAN KE SINI
$routes->post('/track/process', 'TrackOrderController::track'); // DIPINDAHKAN KE SINI

// Rute Autentikasi (Publik)
$routes->get('/login', 'LoginController::index');
$routes->post('/login/process', 'LoginController::processLogin');
$routes->get('/logout', 'LoginController::logout');
$routes->get('/admin/register', 'RegisterController::showSellerRegisterForm');
$routes->post('/admin/register/process', 'RegisterController::processRegister');


// === RUTE YANG DILINDUNGI (PERLU LOGIN) ===
$routes->group('', ['filter' => 'auth'], function ($routes) {

    // Rute untuk Halaman Admin (Penjual)
    $routes->get('/admin', 'AdminController::index');
    $routes->get('/admin/products', 'AdminController::products');
    $routes->get('/admin/products/new', 'AdminController::newProduct');
    $routes->post('/admin/products/create', 'AdminController::createProduct');
    $routes->get('/admin/products/edit/(:num)', 'AdminController::editProduct/$1');
    $routes->put('/admin/products/update/(:num)', 'AdminController::updateProduct/$1');
    $routes->get('/admin/orders', 'AdminController::orders');
    $routes->get('/admin/orders/view/(:num)', 'AdminController::orderDetail/$1');
    $routes->get('/admin/products/delete/(:num)', 'AdminController::deleteProduct/$1');
    $routes->get('/admin/orders/cancel/(:num)', 'AdminController::cancelOrder/$1');

    // Rute untuk Halaman Logistik
    $routes->get('/logistics', 'LogisticsController::index');
    $routes->get('/logistics/orders/view/(:num)', 'LogisticsController::orderDetail/$1');
    $routes->get('/logistics/confirm-reception/(:num)', 'LogisticsController::confirmReception/$1');
    $routes->get('/logistics/confirm-pickup/(:num)', 'LogisticsController::confirmPickup/$1');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
