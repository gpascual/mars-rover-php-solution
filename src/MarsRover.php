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
        if (empty($commands)) {
            return;
        }

        switch ($this->orientation()) {
            case 'N':
                $this->position[0] = 1;
                break;
            case 'E':
                $this->position[1] = 1;
                break;
            case 'S':
                $this->position[0] = -1;
                break;
            case 'W':
                $this->position[1] = -1;
                break;
        }
    }
}
