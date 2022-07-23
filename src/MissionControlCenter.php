<?php

namespace GPascual\MarsRover;

use GPascual\MarsRover\Commands\Command;

use function Lambdish\Phunctional\map;
use function Lambdish\Phunctional\partial;

class MissionControlCenter
{
    public function commands(MarsRover $rover, array $commands): void
    {
        $commandCreatorFunction = partial([Command::class, 'createFromName'], $rover);
        foreach (map($commandCreatorFunction, $commands) as $command) {
            $command();
        }
    }
}
