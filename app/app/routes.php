<?php
declare(strict_types=1);

use App\Application\Controllers\Admin\AdminController;
use App\Application\Controllers\Auth\AuthController;
use App\Application\Controllers\Feed\FeedController;
use App\Application\Controllers\Index\IndexController;
use App\Application\Controllers\L2lOrange\BecomeMentorController;
use App\Application\Controllers\L2lOrange\FindMentorController;
use App\Application\Controllers\L2lOrange\ProfileController;
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

    $app->get('/', function (Request $request, Response $response) use ($container) {
        $controller = $container->get(IndexController::class);
        return $controller->index_get($request);
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
        $app->group('/findMentor', function (Group $group) use ($container) {
            $group->get('', function (Request $request, Response $response) use ($container) {
                $controller = $container->get(FindMentorController::class);
                return $controller->findMentor_get($request);
            });

            $group->post('', function (Request $request, Response $response) use ($container) {
                $controller = $container->get(FindMentorController::class);
                return $controller->findMentor_post($request);
            });
        });

        $app->group('/becomeMentor', function (Group $group) use ($container) {
            $group->get('', function (Request $request, Response $response) use ($container) {
                $controller = $container->get(BecomeMentorController::class);
                return $controller->becomeMentor_get($request);
            });

            $group->post('', function (Request $request, Response $response) use ($container) {
                $controller = $container->get(BecomeMentorController::class);
                return $controller->becomeMentor_post($request);
            });
        });

        $app->group('/profile', function (Group $group) use ($container) {
            $group->get('/myMentors', function (Request $request, Response $response) use ($container) {
                $controller = $container->get(ProfileController::class);
                return $controller->myMentors_get($request);
            });

            $group->get('/myGroups', function (Request $request, Response $response) use ($container) {
                $controller = $container->get(ProfileController::class);
                return $controller->myGroups_get($request);
            });
        });
    })->addMiddleware($container->get(AuthMiddleware::class));

//    $app->group('/admin', function (Group $group) use ($app, $container) {
//        $group->get('/auth_as_user', function (Request $request, Response $response) use ($container) {
//            $adminController = $container->get(AdminController::class);
//
//            return $adminController->authAsUser_get($request);
//        });
//    })->addMiddleware($container->get(AdminAuthMiddlware::class));

};
