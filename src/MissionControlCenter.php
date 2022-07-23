<?php

namespace GPascual\MarsRover;

use GPascual\MarsRover\Commands\Command;

use function Lambdish\Phunctional\each as walk;
use function Lambdish\Phunctional\map;
use function Lambdish\Phunctional\partial;

class MissionControlCenter
{
    public function commands(MarsRover $rover, array $commands): void
    {
        $commandCreator = partial([Command::class, 'createFromName'], $rover);
        walk(
            function (Command $command) {
                $command();
            },
            map($commandCreator, $commands)
        );
    }
}
