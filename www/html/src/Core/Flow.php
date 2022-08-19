<?php
namespace App\Core;

class Flow{

    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

}