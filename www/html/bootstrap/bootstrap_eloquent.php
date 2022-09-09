<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Container\Container;

$container = Container::getInstance();

$capsule = new Capsule;
$params = [
    'host'      => config('DB_HOST'),
    'username'  => config('DB_USER'),
    'password'  => config('DB_PASS'),
    'database'  => config('DB_DATABASE'),
    'driver'    => config('DB_DRIVER'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
];

$capsule->addConnection($params);
$capsule->setEventDispatcher($container->get('events'));
$capsule->setAsGlobal();
$capsule->bootEloquent();