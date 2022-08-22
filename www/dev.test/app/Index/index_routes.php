<?php
use \Illuminate\Support\Facades\Route;
/** @var \Illuminate\Routing\Router $router */

    $router->name('index.home')
        ->get('/',\App\Index\Controllers\IndexController::class.'@index');

    $router->name('index.contact')
        ->get('/contact/{id}',\App\Index\Controllers\IndexController::class.'@index');


Route::get('/lien-he', \App\Index\Controllers\IndexController::class.'@index')->name('index.lien-he');