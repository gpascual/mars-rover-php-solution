<?php

namespace GPascual\MarsRover;

class CardinalPoint
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public static function north(): CardinalPoint
    {
        static $north;
        return $north ?? $north = new CardinalPoint('N');
    }

    public static function east(): CardinalPoint
    {
        static $east;
        return $east ?? $east = new CardinalPoint('E');
    }

    public static function south(): CardinalPoint
    {
        static $south;
        return $south ?? $south = new CardinalPoint('S');
    }

    public static function west()
    {
        static $west;
        return $west ?? $west = new CardinalPoint('W');
    }
}
