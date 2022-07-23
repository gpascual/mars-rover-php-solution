<?php

namespace GPascual\MarsRover;

use GPascual\MarsRover\Commands\Command;

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

    public function commands(array $commands)
    {
        foreach ($commands as $command) {
            if ($command instanceof Command) {
                $command->execute();
                continue;
            }

            switch ($command) {
                case 'b':
                    switch ($this->orientation()) {
                        case CardinalPoint::north():
                            $this->setPosition($this->position->add(new Coordinates(0, -1)));
                            break;
                        case CardinalPoint::east():
                            $this->setPosition($this->position->add(new Coordinates(-1, 0)));
                            break;
                        case CardinalPoint::south():
                            $this->setPosition($this->position->add(new Coordinates(0, 1)));
                            break;
                        case CardinalPoint::west():
                            $this->setPosition($this->position->add(new Coordinates(1, 0)));
                            break;
                    }
                    break;
                case 'l':
                    switch ($this->orientation()) {
                        case CardinalPoint::north():
                            $this->orientation = CardinalPoint::west();
                            break;
                        case CardinalPoint::east():
                            $this->orientation = CardinalPoint::north();
                            break;
                        case CardinalPoint::south():
                            $this->orientation = CardinalPoint::east();
                            break;
                        case CardinalPoint::west():
                            $this->orientation = CardinalPoint::south();
                            break;
                    }
                    break;
                case 'r':
                    switch ($this->orientation()) {
                        case CardinalPoint::north():
                            $this->orientation = CardinalPoint::east();
                            break;
                        case CardinalPoint::east():
                            $this->orientation = CardinalPoint::south();
                            break;
                        case CardinalPoint::south():
                            $this->orientation = CardinalPoint::west();
                            break;
                        case CardinalPoint::west():
                            $this->orientation = CardinalPoint::north();
                            break;
                    }
                    break;
            }
        }
    }
}
