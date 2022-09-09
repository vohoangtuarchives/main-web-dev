<?php
require ROOT . 'src/Core/Autoload.php';

$splConfigs = [

];

spl_autoload_register(function ($class) {
    \Appx\Core\Autoload::loadClass($class);
});

foreach([
    'bootstrap_define.php',
    'bootstrap_view.php',
    'bootstrap_eloquent.php',
    'bootstrap_core.php',
        ] as $bootstrapFiles){

    include __DIR__ . DIRECTORY_SEPARATOR . $bootstrapFiles;
}