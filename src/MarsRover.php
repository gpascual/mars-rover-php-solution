<?php

namespace GPascual\MarsRover;

class MarsRover
{
    private Coordinates $position;
    private string $orientation;

    public function __construct(Coordinates $initialPosition, string $initialOrientation)
    {
        $this->position = $initialPosition;
        $this->orientation = $initialOrientation;
    }

    public function position(): Coordinates
    {
        return $this->position;
    }

    public function orientation(): string
    {
        return $this->orientation;
    }

    public function commands(array $commands)
    {
        foreach ($commands as $command) {
            switch ($command) {
                case 'f':
                    switch ($this->orientation()) {
                        case 'N':
                            $this->position = $this->position->add(new Coordinates(0, 1));
                            break;
                        case 'E':
                            $this->position = $this->position->add(new Coordinates(1, 0));
                            break;
                        case 'S':
                            $this->position = $this->position->add(new Coordinates(0, -1));
                            break;
                        case 'W':
                            $this->position = $this->position->add(new Coordinates(-1, 0));
                            break;
                    }
                    break;
                case 'b':
                    switch ($this->orientation()) {
                        case 'N':
                            $this->position = $this->position->add(new Coordinates(0, -1));
                            break;
                        case 'E':
                            $this->position = $this->position->add(new Coordinates(-1, 0));
                            break;
                        case 'S':
                            $this->position = $this->position->add(new Coordinates(0, 1));
                            break;
                        case 'W':
                            $this->position = $this->position->add(new Coordinates(1, 0));
                            break;
                    }
                    break;
                case 'l':
                    switch ($this->orientation()) {
                        case 'N':
                            $this->orientation = 'W';
                            break;
                        case 'E':
                            $this->orientation = 'N';
                            break;
                        case 'S':
                            $this->orientation = 'E';
                            break;
                        case 'W':
                            $this->orientation = 'S';
                            break;
                    }
                    break;
                case 'r':
                    switch ($this->orientation()) {
                        case 'N':
                            $this->orientation = 'E';
                            break;
                        case 'E':
                            $this->orientation = 'S';
                            break;
                        case 'S':
                            $this->orientation = 'W';
                            break;
                        case 'W':
                            $this->orientation = 'N';
                            break;
                    }
                    break;
            }
        }
    }
}
