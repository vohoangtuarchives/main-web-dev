<?php
namespace App;

use Appx\Core\Request;

class AppResolver{
    public function resolve(Request $request, $next){
        return $next($request);
    }
}