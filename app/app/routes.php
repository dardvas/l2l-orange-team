<?php
declare(strict_types=1);

use App\Application\Controllers\Admin\AdminController;
use App\Application\Controllers\Auth\AuthController;
use App\Application\Controllers\Feed\FeedController;
use App\Application\Controllers\Subscription\SubscriptionController;
use App\Application\Controllers\Test\TestController;
use App\Application\Controllers\Tweet\TweetController;
use App\Application\Middleware\AdminAuthMiddlware;
use App\Application\Middleware\AuthMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $container = $app->getContainer();
    if ($container === null) {
        throw new RuntimeException('Unable to get container instance');
    }

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');

        return $response;
    });

    $app->any('/test', function (Request $request, Response $response) use ($container) {
        $controller = $container->get(TestController::class);

        return $controller->action_test($request);
    });

    // UNAUTHORIZED GROUP
    $app->group('/auth', function (Group $group) use ($container) {
        $group->get('/login', function (Request $request, Response $response) use ($container) {
            $authController = $container->get(AuthController::class);
            return $authController->login_get($request);
        });

        $group->post('/login', function (Request $request, Response $response) use ($container) {
            $authController = $container->get(AuthController::class);
            return $authController->login_post($request);
        });

        $group->post('/logout', function (Request $request, Response $response) use ($container) {
            $authController = $container->get(AuthController::class);
            return $authController->logout_post($request);
        });

        $group->get('/signup', function (Request $request, Response $response) use ($container) {
            $authController = $container->get(AuthController::class);
            return $authController->signup_get($request);
        });

        $group->post('/signup', function (Request $request, Response $response) use ($container) {
            $authController = $container->get(AuthController::class);
            return $authController->signup_post($request);
        });
    });

    // AUTHORIZED GROUP
    $app->group('', function (Group $group) use ($app, $container) {
        $app->group('/feed', function (Group $group) use ($container) {
            $group->get('', function (Request $request, Response $response) use ($container) {
                $feedController = $container->get(FeedController::class);

                return $feedController->feed_get($request);
            });

            $group->get('/{userId}', function (Request $request, Response $response, $args) use ($container) {
                $feedController = $container->get(FeedController::class);

                return $feedController->feedByUserId_get($request, (int) $args['userId']);
            });
        });

        $app->group('/tweet', function (Group $group) use ($container) {
            $group->post('', function (Request $request, Response $response) use ($container) {
                $tweetController = $container->get(TweetController::class);

                return $tweetController->tweet_post($request);
            });
        });

        $app->group('/subscribe', function (Group $group) use ($container) {
            $group->post('', function (Request $request, Response $response) use ($container) {
                $subController = $container->get(SubscriptionController::class);

                return $subController->subscribe_post($request);
            });
        });
    })->addMiddleware($container->get(AuthMiddleware::class));

    $app->group('/admin', function (Group $group) use ($app, $container) {
        $group->get('/auth_as_user', function (Request $request, Response $response) use ($container) {
            $adminController = $container->get(AdminController::class);

            return $adminController->authAsUser_get($request);
        });
    })->addMiddleware($container->get(AdminAuthMiddlware::class));

};
