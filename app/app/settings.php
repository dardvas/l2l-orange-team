<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        'settings' => [
            'displayErrorDetails' => true, // Should be set to false in production
            'logger' => [
                'name' => 'slim-app',
                'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                'level' => Logger::DEBUG,
            ],
            'db' => [
                'host' => 'mysql',
                'port' => '3306',
                'username' => 'dev',
                'password' => 'dev',
                'dbname' => 'database',
            ],
            'recommendations' => [
                'sidebar' => [
                    'other_user_feeds_count' => 5,
                    'tweets_per_user' => 1,
                ],
            ],
            'feed' => [
                'tweets_per_page' => 15,
            ],
        ],
    ]);
};
