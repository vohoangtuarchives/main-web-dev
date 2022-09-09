<?php
function config($key){
    return ([
        'DB_HOST'   => 'localhost',
        'DB_USER'   => 'root',
        'DB_PASS'   => 'root',
        'DB_DATABASE'   => 'local_welovelotto',
        'DB_DRIVER' => 'mysql'
    ])[$key];
}