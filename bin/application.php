<?php

$rootApp = str_replace('bin', '', __DIR__);

require $rootApp . '/vendor/autoload.php';

use App\Bundle\Command\CreateControllerCommand;
use App\Bundle\Command\CreateElasticComponentCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\CommandLoader\FactoryCommandLoader;

$commandLoader = new FactoryCommandLoader(
    [
        CreateControllerCommand::getDefaultName() => static function () {
            return new CreateControllerCommand();
        },
        CreateElasticComponentCommand::getDefaultName() => static function () {
            return new CreateElasticComponentCommand();
        }
    ]
);

$application = new Application();

$application->setCommandLoader($commandLoader);

$application->run();
