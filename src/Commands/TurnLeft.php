<?php

namespace GPascual\MarsRover\Commands;

class TurnLeft extends Command
{
    protected function execute(): void
    {
        $this->rover->setOrientation($this->rover->orientation()->rotate270());
    }
}
