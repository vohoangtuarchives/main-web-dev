<?php

namespace App;

use Illuminate\Pipeline\Pipeline;

class Flow{
    public function handle($request, \Closure $next){
        dump($request);
        echo 'Flow';
        return $next($request);
    }
}