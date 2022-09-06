<?php
require 'vendor/autoload.php';

use \Tuezy\Container\Container;
use \Tuezy\Router\Router;
$container = Container::getInstance();

$container->assign('router', function(){
    return new Router();
});

dump($container->get('router'));