<?php
/**
 * Created by PhpStorm.
 * User: tracy
 * Date: 7/23/2018
 * Time: 3:59 PM
 */

$app = new \Slim\App([
//to show errors: override in Container class
    'settings' =>[
        'displayErrorDetails' => true,
    ]
]);

//to bind items onto the container... this can be done in separate file in bootstrap if hairy
$container = $app->getContainer();


$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
        'cache' => false
    ]);

// Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container->get('request')->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;

};

require __DIR__ . '/../routes/web.php';
