<?php

namespace GPascual\MarsRover\Commands;

use GPascual\MarsRover\MarsRover;
use GPascual\MarsRover\Planet;

class MoveForward extends Command
{
    private Planet $planet;

    public function __construct(MarsRover $rover, Planet $planet)
    {
        parent::__construct($rover);
        $this->planet = $planet;
    }


    protected function execute(): void
    {
        $this->rover->setPosition(
            $this->planet->wrapCoordinates($this->rover->position()->add($this->rover->orientation()))
        );
    }
}
