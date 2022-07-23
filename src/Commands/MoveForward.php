<?php

namespace GPascual\MarsRover\Commands;

use GPascual\MarsRover\CardinalPoint;
use GPascual\MarsRover\Coordinates;

class MoveForward extends Command
{
    public function execute()
    {
        switch ($this->rover->orientation()) {
            case CardinalPoint::north():
                $this->rover->setPosition($this->rover->position()->add(new Coordinates(0, 1)));
                break;
            case CardinalPoint::east():
                $this->rover->setPosition($this->rover->position()->add(new Coordinates(1, 0)));
                break;
            case CardinalPoint::south():
                $this->rover->setPosition($this->rover->position()->add(new Coordinates(0, -1)));
                break;
            case CardinalPoint::west():
                $this->rover->setPosition($this->rover->position()->add(new Coordinates(-1, 0)));
                break;
        }
    }
}
