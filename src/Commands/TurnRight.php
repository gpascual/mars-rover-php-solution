<?php

namespace GPascual\MarsRover\Commands;

use GPascual\MarsRover\CardinalPoint;

class TurnRight extends Command
{
    protected function execute(): void
    {
        switch ($this->rover->orientation()) {
            case CardinalPoint::north():
                $this->rover->setOrientation(CardinalPoint::east());
                break;
            case CardinalPoint::east():
                $this->rover->setOrientation(CardinalPoint::south());
                break;
            case CardinalPoint::south():
                $this->rover->setOrientation(CardinalPoint::west());
                break;
            case CardinalPoint::west():
                $this->rover->setOrientation(CardinalPoint::north());
                break;
        }
    }
}
