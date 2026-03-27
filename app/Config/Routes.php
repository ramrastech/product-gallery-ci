<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @email      info@ramrastech.com
 * @mobile     +91-7317377477
 * @website    https://ramrastech.com
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// -------------------------------------------------------
// Public Routes
// -------------------------------------------------------
$routes->get('/',                         'Home::index');
$routes->get('/products',                 'Products::index');
$routes->get('/products/(:segment)',      'Products::detail/$1');
$routes->get('/category/(:segment)',      'Products::byCategory/$1');
$routes->get('/search',                   'Products::search');
$routes->get('/about',                    'About::index');
$routes->get('/contact',                  'Contact::index');
$routes->get('/faq',                      'Pages::faq');
$routes->get('/privacy',                  'Pages::privacy');
$routes->get('/terms',                    'Pages::terms');
$routes->post('/enquiry/submit',          'Enquiry::submit');
$routes->get('/sitemap.xml',              'Sitemap::index');

// -------------------------------------------------------
// Admin Auth Routes (no filter — public)
// -------------------------------------------------------
$routes->get('/admin/login',              'Admin\Auth::login');
$routes->post('/admin/login',             'Admin\Auth::loginPost');
$routes->get('/admin/logout',             'Admin\Auth::logout');

// -------------------------------------------------------
// Admin Panel Routes (protected by adminAuth filter)
// -------------------------------------------------------
$routes->group('admin', ['filter' => 'adminAuth'], function ($routes) {
    $routes->get('/',                          'Admin\Dashboard::index');

    // Products
    $routes->get('products',                   'Admin\Products::index');
    $routes->get('products/new',               'Admin\Products::create');
    $routes->post('products/save',             'Admin\Products::save');
    $routes->get('products/edit/(:num)',       'Admin\Products::edit/$1');
    $routes->post('products/update/(:num)',    'Admin\Products::update/$1');
    $routes->post('products/delete/(:num)',    'Admin\Products::delete/$1');
    $routes->post('products/images/reorder',  'Admin\Products::reorderImages');
    $routes->post('products/images/delete/(:num)', 'Admin\Products::deleteImage/$1');
    $routes->post('products/images/primary/(:num)', 'Admin\Products::setPrimaryImage/$1');

    // Categories
    $routes->get('categories',                 'Admin\Categories::index');
    $routes->get('categories/new',             'Admin\Categories::create');
    $routes->post('categories/save',           'Admin\Categories::save');
    $routes->get('categories/edit/(:num)',     'Admin\Categories::edit/$1');
    $routes->post('categories/update/(:num)', 'Admin\Categories::update/$1');
    $routes->post('categories/delete/(:num)', 'Admin\Categories::delete/$1');

    // Enquiries
    $routes->get('enquiries',                  'Admin\Enquiries::index');
    $routes->get('enquiries/view/(:num)',      'Admin\Enquiries::view/$1');
    $routes->post('enquiries/status/(:num)',   'Admin\Enquiries::updateStatus/$1');

    // Settings
    $routes->get('settings',                   'Admin\Settings::index');
    $routes->post('settings/save',             'Admin\Settings::save');

    // Themes
    $routes->get('themes',                     'Admin\Themes::index');
    $routes->post('themes/activate',           'Admin\Themes::activate');

    // SEO Management
    $routes->get('page-seo',                        'Admin\PageSeo::index');
    $routes->get('page-seo/edit/(:segment)',        'Admin\PageSeo::edit/$1');
    $routes->post('page-seo/save/(:segment)',       'Admin\PageSeo::save/$1');

    // Media Library
    $routes->get('media',                           'Admin\MediaLibrary::index');
    $routes->post('media/upload',                   'Admin\MediaLibrary::upload');
    $routes->post('media/delete/(:num)',            'Admin\MediaLibrary::delete/$1');
    $routes->get('media/picker',                    'Admin\MediaLibrary::picker');

    // Home Page Content
    $routes->get('home-content',                    'Admin\HomeContent::index');
    $routes->get('home-content/settings',           'Admin\HomeContent::settings');
    $routes->post('home-content/settings/save',     'Admin\HomeContent::saveSettings');
    $routes->get('home-content/section/(:segment)', 'Admin\HomeContent::section/$1');
    $routes->get('home-content/item/new/(:segment)','Admin\HomeContent::newItem/$1');
    $routes->post('home-content/item/create/(:segment)', 'Admin\HomeContent::createItem/$1');
    $routes->get('home-content/item/edit/(:num)',   'Admin\HomeContent::editItem/$1');
    $routes->post('home-content/item/update/(:num)','Admin\HomeContent::updateItem/$1');
    $routes->post('home-content/item/delete/(:num)','Admin\HomeContent::deleteItem/$1');
    $routes->post('home-content/item/reorder/(:num)','Admin\HomeContent::reorderItem/$1');

    // About Page Content
    $routes->get('about-content',                   'Admin\AboutContent::index');
    $routes->get('about-content/settings',          'Admin\AboutContent::settings');
    $routes->post('about-content/settings/save',    'Admin\AboutContent::saveSettings');
    $routes->get('about-content/section/(:segment)','Admin\AboutContent::section/$1');
    $routes->get('about-content/item/new/(:segment)','Admin\AboutContent::newItem/$1');
    $routes->post('about-content/item/create/(:segment)','Admin\AboutContent::createItem/$1');
    $routes->get('about-content/item/edit/(:num)',  'Admin\AboutContent::editItem/$1');
    $routes->post('about-content/item/update/(:num)','Admin\AboutContent::updateItem/$1');
    $routes->post('about-content/item/delete/(:num)','Admin\AboutContent::deleteItem/$1');
    $routes->post('about-content/item/reorder/(:num)','Admin\AboutContent::reorderItem/$1');

    // FAQ Content
    $routes->get('faq',                             'Admin\FaqContent::index');
    $routes->post('faq/category/save',              'Admin\FaqContent::saveCategory');
    $routes->post('faq/category/delete/(:num)',     'Admin\FaqContent::deleteCategory/$1');
    $routes->get('faq/item/new',                    'Admin\FaqContent::newItem');
    $routes->get('faq/item/new/(:num)',             'Admin\FaqContent::newItem/$1');
    $routes->get('faq/item/edit/(:num)',            'Admin\FaqContent::editItem/$1');
    $routes->post('faq/item/save',                  'Admin\FaqContent::saveItem');
    $routes->post('faq/item/delete/(:num)',         'Admin\FaqContent::deleteItem/$1');
    $routes->post('faq/item/reorder/(:num)',        'Admin\FaqContent::reorderItem/$1');

    // Legal Page Content (Privacy / Terms)
    $routes->get('page-content/(:segment)',         'Admin\PageContent::edit/$1');
    $routes->post('page-content/(:segment)/save',   'Admin\PageContent::save/$1');
});
