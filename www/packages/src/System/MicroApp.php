<?php
namespace Packages\System;

use Illuminate\Container\Container;

class Application extends Container{

    protected $basePath;

    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }
}