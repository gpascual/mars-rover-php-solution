<?php

namespace GPascual\MarsRover\Commands;

class MoveForward extends Command
{
    protected function execute(): void
    {
        $this->rover->setPosition(
            $this->rover->position()->add($this->rover->orientation())
        );
    }
}
