<?php
require 'vendor/autoload.php';

use App\Core\Application;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Cache\Factory as CacheFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Queue\Factory as QueueFactoryContract;
use Illuminate\Contracts\Routing\ResponseFactory as ResponseFactoryContract;
use Illuminate\Contracts\Routing\UrlGenerator as UrlGeneratorContract;
use Illuminate\Contracts\View\Factory as ViewFactoryContract;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Routing\Contracts\ControllerDispatcher as ControllerDispatcherContract;
use Illuminate\Routing\ControllerDispatcher;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Routing\Router;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Session\FileSessionHandler;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Session\SessionManager;
use Illuminate\Session\Store;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use \Symfony\Component\HttpFoundation\Request;
function app(){
    return Application::getInstance();
}
function session() : Store
{
    return app()->make('session.store');
}
$app = Application::getInstance();
Application::setInstance($app);
$app->instance('app', $app);
$app->instance(\Illuminate\Container\Container::class, $app);

$app->instance('config', $config = new Repository([
    'session' => [
        'driver' => 'file',
        'lifetime' => 60,
        'expire_on_close' => true,
        'files' => 'framework/sessions',
    ]
                                                  ]));

$app->singleton('router', function ($app) {
    return new Router($app['events'], $app);
});
$app->singleton('url', function ($app) {
    $routes = $app['router']->getRoutes();

    // The URL generator needs the route collection that exists on the router.
    // Keep in mind this is an object, so we're passing by references here
    // and all the registered routes will be available to the generator.
    $app->instance('routes', $routes);

    return new UrlGenerator(
        $routes, $app->rebinding(
        'request', $this->requestRebinder()
    ), $app['config']['app.asset_url']
    );
});

$app->singleton('files', function () {
    return new Filesystem;
});

$app->singleton('session', function ($app) {
    return new SessionManager($app);
});
$app->singleton('session.store', function ($app) {
    // First, we will create the session manager which is responsible for the
    // creation of the various session drivers when they are needed by the
    // application instance, and will resolve them on a lazy load basis.
    return new Store("app_session", new FileSessionHandler(
        $app->make('files'),
        'framework/session',
        60

    ));
});

$app->singleton(StartSession::class, function ($app) {
    return new StartSession($app->make(SessionManager::class), function ($app) {
        return $app->make(CacheFactory::class);
    });
});
$app->singleton('redirect', function ($app) {
    $redirector = new Redirector($app['url']);

    // If the session is set on the application instance, we'll inject it into
    // the redirector instance. This allows the redirect responses to allow
    // for the quite convenient "with" methods that flash to the session.
    if (isset($app['session.store'])) {
        $redirector->setSession($app['session.store']);
    }

    return $redirector;
});

$app->bind(ServerRequestInterface::class, function ($app) {
    if (class_exists(Psr17Factory::class) && class_exists(PsrHttpFactory::class)) {
        $psr17Factory = new Psr17Factory;

        return (new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory))
            ->createRequest($app->make('request'));
    }

    throw new BindingResolutionException('Unable to resolve PSR request. Please install the symfony/psr-http-message-bridge and nyholm/psr7 packages.');
});

$app->bind(ResponseInterface::class, function () {
    if (class_exists(PsrResponse::class)) {
        return new PsrResponse;
    }

    throw new BindingResolutionException('Unable to resolve PSR response. Please install the nyholm/psr7 package.');
});

$app->singleton(ResponseFactoryContract::class, function ($app) {
    return new ResponseFactory($app[ViewFactoryContract::class], $app['redirect']);
});

$app->singleton(ControllerDispatcherContract::class, function ($app) {
    return new ControllerDispatcher($app);
});
$request = Request::createFromGlobals();


$response =  (new \Illuminate\Routing\Pipeline($app))->send($request)->through([
                                                                                   \App\Core\FilterContent::class
                                                                               ])->then(
   function($request){
       return (new \Symfony\Component\HttpFoundation\Response("Hello world", 200, []))->prepare($request);
   }
);
echo $request->getSession('first') ?: 'init';
$response->send();