<?php

namespace GPascual\MarsRover\Commands;

use GPascual\MarsRover\CardinalPoint;
use GPascual\MarsRover\Coordinates;

class MoveBackward extends Command
{
    protected function execute(): void
    {
        $this->rover->setPosition(
            $this->rover->position()->add($this->rover->orientation()->getNormalVector()->scalarMultiply(-1))
        );
    }
}
