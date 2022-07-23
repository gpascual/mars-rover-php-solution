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
        foreach ($commands as $command) {
            switch ($command) {
                case 'f':
                    switch ($this->orientation()) {
                        case 'N':
                            ++$this->position[0];
                            break;
                        case 'E':
                            ++$this->position[1];
                            break;
                        case 'S':
                            --$this->position[0];
                            break;
                        case 'W':
                            --$this->position[1];
                            break;
                    }
                    break;
                case 'b':
                    switch ($this->orientation()) {
                        case 'N':
                            --$this->position[0];
                            break;
                        case 'E':
                            --$this->position[1];
                            break;
                        case 'S':
                            ++$this->position[0];
                            break;
                        case 'W':
                            ++$this->position[1];
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
            }
        }
    }
}
