<?php
require 'vendor/autoload.php';

use Illuminate\Contracts\Http\Kernel as HttpKernel;
use App\Kernel;

$app = new \App\Application(__DIR__);

$app->singleton(
    HttpKernel::class,
    Kernel::class);

$kernel = $app->make(HttpKernel::class);

$response = $kernel->handle(
    $request = \Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);

