<?php
namespace App\Core;

abstract class Filter{
    public abstract function before($request);
    public abstract function after($request);
    public function handle($request, $next){
        $this->before($request);
        $next($request);
        $this->after($request);
    }
}