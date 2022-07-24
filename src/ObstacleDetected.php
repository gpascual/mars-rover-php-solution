<?php

namespace GPascual\MarsRover;

class ObstacleDetected extends \RuntimeException
{
    public function __construct(MarsRover $rover, Coordinates $obstacleCoordinates)
    {
        parent::__construct("An obstacle detected at $obstacleCoordinates, the rover remains at $rover");
    }
}
