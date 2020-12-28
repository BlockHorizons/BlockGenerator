<?php

namespace BlockHorizons\BlockGenerator\math;

class FacingHelper
{

    public const AXIS_Y = 0;
    public const AXIS_Z = 1;
    public const AXIS_X = 2;
    public const FLAG_AXIS_POSITIVE = 1;
    public const DOWN = 0;
    public const UP = 1;
    public const NORTH = 2;
    public const SOUTH = 3;
    public const WEST = 4;
    public const EAST = 5;

    public const HORIZONTAL = [self::NORTH, self::SOUTH, self::EAST, self::WEST];
    public const VERTICAL = [self::UP, self::DOWN];

    public static function opposite(int $direction): int
    {
        switch ($direction) {
            case self::EAST:
                return self::WEST;
            case self::WEST:
                return self::EAST;
            case self::NORTH:
                return self::SOUTH;
            case self::SOUTH:
                return self::NORTH;
            case self::UP:
                return self::DOWN;
            case self::DOWN:
                return self::UP;
            default:
                return -1;
        }
    }

    public static function random(array $faces): int
    {
        return $faces[mt_rand(0, count($faces) - 1)];
    }

    public static function __test()
    {
        // N
        // S
        // w
        // E
        // U
        // D
        $faces = [
            "North" => self::NORTH,
            "South" => self::SOUTH,
            "West" => self::WEST,
            "East" => self::EAST,
            "Up" => self::UP,
            "Down" => self::DOWN
        ];
        foreach ($faces as $name => $face) {
            echo " ---- Face: $name ----" . PHP_EOL;
            echo " xOffset: " . self::xOffset($face) . PHP_EOL;
            echo " yOffset: " . self::yOffset($face) . PHP_EOL;
            echo " zOffset: " . self::zOffset($face) . PHP_EOL;
        }
    }

    public static function xOffset(int $face): int
    {
        return self::offset($face, self::AXIS_X);
    }

    public static function offset(int $face, int $axis): int
    {
        return (self::axis($face) === $axis ? (($face % 2) > 0 ? 1 : -1) : 0);
    }

    public static function axis(int $direction): int
    {
        switch ($direction) {
            case self::EAST:
            case self::WEST:
                return self::AXIS_X;
            case self::NORTH:
            case self::SOUTH:
                return self::AXIS_Z;
            case self::UP:
            case self::DOWN:
                return self::AXIS_Y;
            default:
                return -1;
        }
    }

    public static function yOffset(int $face): int
    {
        return self::offset($face, self::AXIS_Y);
    }

    public static function zOffset(int $face): int
    {
        return self::offset($face, self::AXIS_Z);
    }

}