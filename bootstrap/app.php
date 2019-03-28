<?php
    session_start();

    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

    use Respect\Validation\Validator as v;
    use oTikets\Classes\Config as get;

    use Tuupola\Middleware\HttpBasicAuthentication;
    
    use \Illuminate\Database\Capsule\Manager as Capsule;


    require __DIR__.'/../vendor/autoload.php';

    $mode = file_get_contents(__DIR__.'/../configuration');

    $app = new \Slim\App(get::configuration($mode));

    $container = $app->getContainer();

    $v = $container->get('app')['api-version'];

    $container['api_version'] = function ($container){
        return $container->get('app')['api-version'];
    };

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

    $container['logger'] = function ($container) use ($settings){
        $logger = new \Monolog\Logger($settings['name']);
        $file_handler = new \Monolog\Handler\StreamHandler($settings['path']);
        $logger->pushHandler($file_handler);

        return $logger;
    };

    $container['mailer'] = function ($container) use ($mailer){
        return new \oTikets\Classes\Mail\Mailer($container, $mailer);
    };

    $container['validator'] = function ($container){
        return new \oTikets\Classes\Validation\Validator;
    };

    $container["jwt"] = function ($container) {
        return new StdClass;
    };

    $container['jwt_builder'] = function ($container){
        return new \Lcobucci\JWT\Builder();
    };

    $container['jwt_parser'] = function ($container){
        return new \Lcobucci\JWT\Parser();
    };

    $container['jwt_signer'] = function ($container){
        return new \Lcobucci\JWT\Signer\Hmac\Sha512;
    };

    $container['jwt_secret'] = function ($container){
        return $container->get('settings')['jwt']['secret'];
    };

    $container['help_me'] = function ($container){
        return new \oTikets\Helpers\Helpers;
    };
    
    $container['config'] = function ($container){
        return new \oTikets\Classes\Config($container);
    };

    $container['api_response'] = function ($container){
        return new \oTikets\Classes\Responses\Responses($container);
    };

    $container['auth'] = function ($container){
        return new \oTikets\Classes\Auth\Authentication($container);
    };

    $container['user'] = function ($container){
        return new \oTikets\Classes\Users\Users($container);
    };

    $container['organizer'] = function ($container){
        return new \oTikets\Classes\Users\Organizers($container);
    };

    $container['event'] = function ($container){
        return new \oTikets\Classes\Events\Events($container);
    };

    $container['VersionController'] = function ($container){
        return new \oTikets\Controllers\v1\VersionController($container);
    };

    $container['AuthController'] = function ($container){
        return new \oTikets\Controllers\v1\AuthController($container);
    };

    $container['UsersController'] = function ($container){
        return new \oTikets\Controllers\v1\UsersController($container);
    };

    $container['OrganizerController'] = function ($container){
        return new \oTikets\Controllers\v1\OrganizerController($container);
    };

    $container['EventsController'] = function ($container){
        return new \oTikets\Controllers\v1\EventsController($container);
    };

    v::with('oTikets\\Classes\\Validation\\Rules\\');

    require __DIR__.'/../routes/router.php';
