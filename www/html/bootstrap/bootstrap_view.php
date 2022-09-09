<?php

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\DynamicComponent;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\FileEngine;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\FileViewFinder;

$viewPaths = ROOT . 'resources/views';
$cachePath = ROOT . 'cache/views';

$container = Container::getInstance();

$container->bindIf('files', function () {
    return new Filesystem;
}, true);

$container->bindIf('events', function () {
    return new Dispatcher;
}, true);

$container->bindIf('config', function () use ($viewPaths, $cachePath) {
    return collect([
                       'view.paths' => $viewPaths,
                       'view.compiled' => $cachePath,
                   ]);
}, true);

$container->singleton('view', function ($container) {
    // Next we need to grab the engine resolver instance that will be used by the
    // environment. The resolver will be used by an environment to get each of
    // the various engine implementations such as plain PHP or Blade engine.
    $resolver = $container['view.engine.resolver'];

    $finder = $container['view.finder'];

    $factory = new \Illuminate\View\Factory($resolver, $finder, $container['events']);

    // We will also set the container instance on this view environment since the
    // view composers may be classes registered in the container, which allows
    // for great testable, flexible composers for the application developer.
    $factory->setContainer($container);

    $factory->share('app', $container);

    $factory->addNamespace('default', $container['config']['view.paths']);

    return $factory;
});
$container->bind('view.finder', function ($container) {
    return new FileViewFinder($container['files'], [$container['config']['view.paths']]);
});

$container->singleton('blade.compiler', function ($container) {
    return tap(new BladeCompiler($container['files'], $container['config']['view.compiled']), function ($blade) {
        $blade->component('dynamic-component', DynamicComponent::class);
    });
});
$container->singleton('view.engine.resolver', function () use($container){
    $resolver = new EngineResolver;

    // Next, we will register the various view engines with the resolver so that the
    // environment will resolve the engines needed for various views based on the
    // extension of view file. We call a method for each of the view's engines.
    $resolver->register('file', function () use($container) {
        return new FileEngine($container['files']);
    });
    $resolver->register('php', function () use($container){
        return new PhpEngine($container['files']);
    });
    $resolver->register('blade', function () use($container){
        return new CompilerEngine($container['blade.compiler'], $container['files']);
    });

    return $resolver;
});




