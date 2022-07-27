<?php

namespace GPascual\MarsRover;

class UnknownCommand extends \InvalidArgumentException
{
    public function __construct(string $commandName)
    {
        parent::__construct("Unknown command '$commandName'");
    }
}
