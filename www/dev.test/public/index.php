<?php
declare(strict_types=1);
require 'vendor/autoload.php';

$app = new \Packages\System\MicroApp(__DIR__);
$app->setPathApplication([
    'configs',
    'caches',
    'app'
]);