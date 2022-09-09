<?php
namespace Appx\Core;

use Illuminate\Container\Container;

class Request{
    protected $items;
    public function __construct()
    {
        $this->items = Container::getInstance();
    }
}