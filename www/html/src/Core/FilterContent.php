<?php
namespace App\Core;

use Symfony\Component\HttpFoundation\Request;

class FilterContent{

   public function handle(Request $request, $next){
       session()->put('first', 1);
       return $next($request);
   }

}