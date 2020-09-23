<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::view('/', 'home')->name('home');

Route::get('/boutique', function () {
    return view('boutique');
});

Route::get('/products/{product}', function () {
    return view('product');
});

//Route::get('/home', 'HomeController@index')->name('home');
Route::view('/admin', 'admin')->name('admin')->middleware('admin');
Route::get('/admin/{path}','AdminController@index')->where( 'path', '([A-z\d\-/_.]+)?' );

Route::post('store_file', 'FileUploadController@fileStore');
