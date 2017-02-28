<?php

error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);

spl_autoload_register(function ($className) {
    include sprintf("../%s.php", str_replace('\\', "/", $className));
});

/**
 * Environment variable
 */
try {
    (new RedCrown\EnvParser(dirname(__DIR__)))->parse();
} catch (Exception $e) {
    die($e->getMessage());
}

/**
 * Application instance
 */
$config = require dirname(__DIR__). '/RedCrown/config.php';
$app = new RedCrown\Application('prod', $config);

/**
 * Routes
 */
$app->router->get("/", function () use ($app) {
    $template = $app->getRootDir() . "/App/Views/index.phtml";

    $repository = $app->container->get('App\Repository\UserRepository');
    $user = $repository->findRandom();

    echo new RedCrown\Http\Response(
        $app->container->get('templater')->render($template, [
            'title' => 'Index page',
            'user' => $user
        ])
    );
});


/**
 * Error callback
 */
$app->router->error(function (Exception $exception) use ($app) {

    $template = $app->getRootDir() . "/App/Views/error.phtml";
    echo new RedCrown\Http\Response(
        $app->container->get('templater')->render($template, [
            'statusCode' => $exception->getStatusCode(),
            'message' => $exception->getMessage()
        ]),
        $exception->getStatusCode()
    );
});

/**
 * Start application
 */
$app->run();
