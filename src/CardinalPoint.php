<?php

namespace GPascual\MarsRover;

class CardinalPoint
{
    private string $name;
    private ?Coordinates $normalVector;

    public function __construct(string $name, Coordinates $normalVector = null)
    {
        $this->name = $name;
        $this->normalVector = $normalVector;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getNormalVector(): Coordinates
    {
        return $this->normalVector;
    }

    public function left(): CardinalPoint
    {
        return match ($this) {
            self::north() => self::west(),
            self::east() => self::north(),
            self::south() => self::east(),
            self::west() => self::south()
        };
    }

    public function right(): CardinalPoint
    {
        return match ($this) {
            self::north() => self::east(),
            self::east() => self::south(),
            self::south() => self::west(),
            self::west() => self::north()
        };
    }

    public static function north(): CardinalPoint
    {
        static $north;
        return $north ?? $north = new CardinalPoint('N', new Coordinates(0, 1));
    }

    public static function east(): CardinalPoint
    {
        static $east;
        return $east ?? $east = new CardinalPoint('E', new Coordinates(1, 0));
    }

    public static function south(): CardinalPoint
    {
        static $south;
        return $south ?? $south = new CardinalPoint('S', new Coordinates(0, -1));
    }

    public static function west()
    {
        static $west;
        return $west ?? $west = new CardinalPoint('W', new Coordinates(-1, 0));
    }
}
