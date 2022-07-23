<?php

namespace GPascual\MarsRover;

class Planet
{
    private int $maxLongitude;
    private int $maxLatitude;

    public function __construct(int $maxLongitude, int $maxLatitude)
    {
        $this->maxLongitude = $maxLongitude;
        $this->maxLatitude = $maxLatitude;
    }

    public function wrapCoordinates(Coordinates $coordinates): Coordinates
    {
        return $coordinates->wrap($this->maxLongitude, $this->maxLatitude);
    }
}
