<?php

use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',function()
    {
        return view('AdminSide.AddProducts');
    });

Auth::routes();



// Routes For Admin
Route::post('/product','App\Http\Controllers\ProductController@store')->name('products.store');

//Routes for User
Route::get('/home','App\Http\Controllers\ProductController@index')->name('home')->middleware('auth');
Route::post('/product/cart/{id}','App\Http\Controllers\CartController@store')->middleware('auth');
Route::get('/product/cart','App\Http\Controllers\CartController@index')->middleware('auth');
Route::get('/product/invoice','App\Http\Controllers\CartController@create')->middleware('auth');
Route::post('/product/order','App\Http\Controllers\OrderController@store')->middleware('auth');
Route::get('/product/order','App\Http\Controllers\OrderController@index')->middleware('auth');
Route::post('/product/rating','App\Http\Controllers\ProductController@rating')->middleware('auth');