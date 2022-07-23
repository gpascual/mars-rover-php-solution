<?php

namespace GPascual\MarsRover\Commands;

class TurnRight extends Command
{
    protected function execute(): void
    {
        $this->rover->setOrientation($this->rover->orientation()->rotate90());
    }
}
