<?php

namespace GPascual\MarsRover\Commands;

use GPascual\MarsRover\MarsRover;
use GPascual\MarsRover\Planet;
use GPascual\MarsRover\UnknownCommand;

abstract class Command
{
    protected MarsRover $rover;

    protected function __construct(MarsRover $rover)
    {
        $this->rover = $rover;
    }

    public static function createFromName(MarsRover $rover, Planet $planet, string $commandName): Command
    {
        return match ($commandName) {
            'f' => new MoveForward($rover, $planet),
            'b' => new MoveBackward($rover, $planet),
            'l' => new TurnLeft($rover),
            'r' => new TurnRight($rover),
            default => throw new UnknownCommand($commandName),
        };
    }

    final public function __invoke(): void
    {
        $this->execute();
    }

    abstract protected function execute(): void;
}
