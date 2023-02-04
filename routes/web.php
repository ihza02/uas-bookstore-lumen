<?php

use Illuminate\Support\Facades\Route;

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

Route::group(['middleware' => ['auth']], function ($router) {

    //Shops
    $router->get('admin/shops', 'ShopsController@index');
    $router->get('admin/shop/{id}', 'ShopsController@show');
    $router->post('admin/shops', 'ShopsController@store');
    $router->put('admin/shop/{id}', 'ShopsController@update');
    $router->delete('admin/shop/{id}', 'ShopsController@destroy');

    //Books
    $router->get('admin/books', 'BooksController@index');
    $router->get('admin/book/{id}', 'BooksController@show');
    $router->post('admin/books', 'BooksController@store');
    $router->put('admin/book/{id}', 'BooksController@update');
    $router->delete('admin/book/{id}', 'BooksController@destroy');

    //Public Books
    $router->get('/user/books', 'PublicController\BooksController@index');
    $router->get('/user/book/{id}', 'PublicController\BooksController@show');

    //Transactions
    $router->get('user/transactions', 'PublicController\TransactionsController@index');
    $router->get('user/transaction/{id}', 'PublicController\TransactionsController@show');
    $router->post('user/transactions', 'PublicController\TransactionsController@store');
    $router->put('user/transaction/{id}', 'PublicController\TransactionsController@update');
    $router->delete('user/transaction/{id}', 'PublicController\TransactionsController@destroy');
    $router->get('admin/transactions', 'TransactionsController@index');
    $router->get('admin/transaction/{id}', 'TransactionsController@show');

    //Users
    $router->get('admin/users', 'UsersController@index');
    $router->get('admin/user/{id}', 'UsersController@show');
});

// authentication
$router->group(['prefix' => 'auth'], function () use ($router){
    // Matches "/api/register
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');
});
