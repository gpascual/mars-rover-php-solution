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
        switch ($commandName) {
            case 'f':
                return new MoveForward($rover);
        }
        return $commandName;
    }

    abstract public function execute();
}
