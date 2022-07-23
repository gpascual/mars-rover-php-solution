<?php

namespace GPascual\MarsRover;

class MarsRover
{
    private Coordinates $position;
    private CardinalPoint $orientation;

    public function __construct(Coordinates $initialPosition, CardinalPoint $initialOrientation)
    {
        $this->position = $initialPosition;
        $this->orientation = $initialOrientation;
    }

    public function position(): Coordinates
    {
        return $this->position;
    }

    public function setPosition(Coordinates $position): void
    {
        $this->position = $position;
    }

    public function orientation(): CardinalPoint
    {
        return $this->orientation;
    }

    public function setOrientation(CardinalPoint $orientation): void
    {
        $this->orientation = $orientation;
    }
}
