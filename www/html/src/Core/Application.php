<?php
namespace App\Core;

use Illuminate\Container\Container;

class Application extends Container{

    public function isDownForMaintenance(): bool
    {
        return false;
    }

    public function environment(...$environments)
    {
        if(empty($environments)) {
            return 'app';
        }

        return in_array(
            'app',
            is_array($environments[0]) ? $environments[0] : $environments
        );
    }

    public function getNamespace(): string
    {
        return 'App\\';
    }

}