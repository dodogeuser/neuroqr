<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.home')->name('home');
Route::view('/about', 'pages.about')->name('about');
Route::view('/services', 'pages.services')->name('services');
Route::view('/products', 'pages.products')->name('products');
Route::view('/products/nexa', 'pages.nexa')->name('nexa');
Route::view('/contact', 'pages.contact')->name('contact');

// Keep previously advertised company and QR product URLs useful.
Route::redirect('/company', '/about', 301);
Route::redirect('/products/intelligent-qr', '/products/nexa', 301);
Route::redirect('/pricing', '/products/nexa', 301);

foreach ([
    '/index.html' => '/',
    '/products/index.html' => '/products',
    '/products/intelligent-qr/index.html' => '/products/nexa',
    '/services/index.html' => '/services',
    '/pricing/index.html' => '/products/nexa',
    '/company/index.html' => '/about',
    '/contact/index.html' => '/contact',
] as $oldPath => $destination) {
    Route::redirect($oldPath, $destination, 301);
}

Route::redirect('/products/wooperly', '/products/nexa', 301);
