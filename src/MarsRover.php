<?php

namespace GPascual\MarsRover;

class MarsRover
{
    private array $position;
    private string $orientation;

    public function __construct(array $initialPosition, string $initialOrientation)
    {
        $this->position = $initialPosition;
        $this->orientation = $initialOrientation;
    }

    public function position(): array
    {
        return $this->position;
    }

    public function orientation(): string
    {
        return $this->orientation;
    }

    public function commands(array $commands)
    {
    }
}
