<?php

namespace GPascual\MarsRover;

use function Lambdish\Phunctional\memoize;

class Coordinates
{
    /** @var ?callable */
    protected static $creator;

    protected int $x;
    protected int $y;

    public static function create(int $x, int $y): static
    {
        // Forced to create a closure by limitations of Phunctional::memoize() working with a callable in array form
        return memoize(
            static::$creator ?? static::$creator = \Closure::fromCallable([static::class, 'createInternal']),
            $x,
            $y
        );
    }

    private static function createInternal(int $x, int $y): static
    {
        return new static($x, $y);
    }

    protected function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function rotate90(): static
    {
        return static::create($this->y, -$this->x);
    }

    public function rotate180(): static
    {
        return static::create(-$this->x, -$this->y);
    }

    public function rotate270(): static
    {
        return static::create(-$this->y, $this->x);
    }

    public function add(Coordinates $increment): self
    {
        return self::create($this->x + $increment->x, $this->y + $increment->y);
    }

    public function wrap(int $maxX, int $maxY): self
    {
        $modX = $maxX + 1;
        $modY = $maxY + 1;
        return self::create(($this->x + $modX) % $modX, ($this->y + $modY) % $modY);
    }

    public function __toString(): string
    {
        return "{ x: {$this->x}, y: {$this->y} }";
    }
}
