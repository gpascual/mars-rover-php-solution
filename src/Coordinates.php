<?php

namespace GPascual\MarsRover;

class Coordinates
{
    private int $x;
    private int $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function add(Coordinates $increment): self
    {
        return new self($this->x + $increment->x, $this->y + $increment->y);
    }

    public function scalarMultiply(int $factor): self
    {
        return new self($this->x * $factor, $this->y * $factor);
    }
}
