<?php

namespace GPascual\MarsRover;

class CardinalPoint
{
    private Coordinates $normalVector;

    private function __construct(Coordinates $normalVector = null)
    {
        $this->normalVector = $normalVector;
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
        return $north ?? $north = new CardinalPoint(new Coordinates(0, 1));
    }

    public static function east(): CardinalPoint
    {
        static $east;
        return $east ?? $east = new CardinalPoint(new Coordinates(1, 0));
    }

    public static function south(): CardinalPoint
    {
        static $south;
        return $south ?? $south = new CardinalPoint(new Coordinates(0, -1));
    }

    public static function west()
    {
        static $west;
        return $west ?? $west = new CardinalPoint(new Coordinates(-1, 0));
    }
}
