<?php

namespace BlockHorizons\BlockGenerator\populator\helper;

use pocketmine\block\Block;
use pocketmine\level\format\Chunk;

class PopulatorHelpers
{

    const NON_SOLID = [
        Block::AIR => true,
        Block::LEAVES => true,
        Block::LEAVES2 => true,
        Block::SNOW_LAYER => true,
        Block::TALL_GRASS => true,
    ];

    private function __construct()
    {
    }

    public static function canGrassStay(int $x, int $y, int $z, Chunk $chunk): bool
    {
        return EnsureCover::ensureCover($x, $y, $z, $chunk) && EnsureGrassBelow::ensureGrassBelow($x, $y, $z, $chunk);
    }

    public static function isNonSolid(int $id): bool
    {
        return isset(self::NON_SOLID[$id]);
    }

}