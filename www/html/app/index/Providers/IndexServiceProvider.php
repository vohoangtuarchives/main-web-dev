<?php
namespace App\Admin\Providers;

use Appx\Core\ServiceProvider;
use Illuminate\Container\Container;

class AdminServiceProvider extends ServiceProvider {

    public function register()
    {
        // TODO: Implement register() method.
    }

    public function boot()
    {
        view()->addNamespace('admin', ROOT . dirname(__DIR__).DIRECTORY_SEPARATOR."Resources/views");
        include dirname(__DIR__).DIRECTORY_SEPARATOR.'routes.php';
    }
}