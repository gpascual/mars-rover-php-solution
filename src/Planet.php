<?php

namespace GPascual\MarsRover;

class Planet
{
    private int $maxLongitude;
    private int $maxLatitude;
    private array $obstacles;

    /**
     * @param Coordinates[] $obstacles
     */
    public function __construct(int $maxLongitude, int $maxLatitude, array $obstacles = [])
    {
        $this->maxLongitude = $maxLongitude;
        $this->maxLatitude = $maxLatitude;
        $this->obstacles = $obstacles;
    }

    public function wrapCoordinates(Coordinates $coordinates): Coordinates
    {
        return $coordinates->wrap($this->maxLongitude, $this->maxLatitude);
    }

    public function hasAnObstacleThere(Coordinates $coordinates): bool
    {
        return in_array($coordinates, $this->obstacles, true);
    }
}
