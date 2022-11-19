<?php
declare(strict_types=1);

use App\Domain\Feed\FeedConfig;
use App\Domain\Social\RecommendationsConfig;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get('settings');

            $loggerSettings = $settings['logger'];
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        RecommendationsConfig::class => function (ContainerInterface $c) {
            $settings = $c->get('settings');
            $sidebarOtherUserFeedsCount = (int) $settings['recommendations']['sidebar']['other_user_feeds_count'];
            $sidebarTweetsPerUser = (int) $settings['recommendations']['sidebar']['tweets_per_user'];

            return new RecommendationsConfig($sidebarOtherUserFeedsCount, $sidebarTweetsPerUser);
        },
        FeedConfig::class => function (ContainerInterface $c) {
            $settings = $c->get('settings');
            $tweetsPerPage = $settings['feed']['tweets_per_page'];

            return new FeedConfig($tweetsPerPage);
        }
    ]);
};
