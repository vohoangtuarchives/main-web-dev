<?php

namespace App\Index\Controllers;

use Illuminate\Http\Request;
use Packages\Controller;

class IndexController extends Controller {
    public function index(Request $request){
        return view('index::home', [
            'pageTitle' => 'Homepage'
        ]);
    }

}