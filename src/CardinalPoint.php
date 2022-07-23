<?php

namespace GPascual\MarsRover;

class CardinalPoint extends Coordinates
{
    protected static $creator;

    public static function north(): CardinalPoint
    {
        return static::create(0, 1);
    }

    public static function east(): CardinalPoint
    {
        return static::create(1, 0);
    }

    public static function south(): CardinalPoint
    {
        return static::create(0, -1);
    }

    public static function west(): CardinalPoint
    {
        return static::create(-1, 0);
    }
}
