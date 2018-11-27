<?php
    session_start();

    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

    use Respect\Validation\Validator as v;
    use Ticket\Classes\Config as get;
    
    use \Illuminate\Database\Capsule\Manager as Capsule;


    require __DIR__.'/../vendor/autoload.php';

    $mode = file_get_contents(__DIR__.'/../configuration');

    $app = new \Slim\App(get::configuration($mode));

    $container = $app->getContainer();

    $settings = $container->get('settings')['logger'];
    $db_conn = $container->get('settings')['db'];
    $app_config = $container->get('app');

    $mailer = $container->get('settings')['mail'];
    $sms = $container->get('settings')['sms'];

    $capsule = new Capsule;
    $capsule->addConnection($db_conn);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    $container['db'] = function ($container) use ($capsule){
        return $capsule;
    };

    $container['view'] = function ($container) use ($app_config){
        $view = new \Slim\Views\Twig(__DIR__.'/../resources', [
            'cache' => false
        ]);

        $view->addExtension(new \Slim\Views\TwigExtension(
            $container->router, $container->request->getUri()
        ));

        $view->getEnvironment()->addGlobal('app', $app_config);


        return $view;
    };

    $container['logger'] = function ($container){
        $logger = new \Monolog\Logger($settings['name']);
        $file_handler = new \Monolog\Handler\StreamHandler($settings['path']);
        $logger->pushHandler($file_handler);
        return $logger;
    };

    // $container['validator'] = function ($container){
    //     return new \Ticket\Classes\Validation\Validator;
    // };

    $container['randomlib'] = function ($container){
        $factory = new \RandomLib\Factory;

        return $factory->getHighStrengthGenerator();
    };

    $container['config'] = function ($container){
        return new \Ticket\Classes\Config($container);
    };

    $container['VersionController'] = function ($container){
        return new \Ticket\Controllers\v1\VersionController($container);
    };

    require __DIR__.'/../routes/Router.php';
