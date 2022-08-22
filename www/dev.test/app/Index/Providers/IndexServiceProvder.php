<?php
namespace App\Index\Providers;


use Illuminate\Support\ServiceProvider;

class IndexProvder extends ServiceProvider
{

    public function register()
    {
        echo '1';
//        $router = $this->router;
//        $this->view->addNamespace(
//            'index',
//            dirname(__DIR__) . DIRECTORY_SEPARATOR
//
//        );
//        include dirname(__DIR__) . '/index_routes.php';
    }

}