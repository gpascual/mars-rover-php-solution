<?php

namespace GPascual\MarsRover\Commands;

use GPascual\MarsRover\MarsRover;

abstract class Command
{
    protected MarsRover $rover;

    public function __construct(MarsRover $rover)
    {
        $this->rover = $rover;
    }

    public static function createFromName(MarsRover $rover, string $commandName)
    {
        return match ($commandName) {
            'f' => new MoveForward($rover),
            'b' => new MoveBackward($rover),
            default => $commandName,
        };
    }

    abstract public function execute();
}
