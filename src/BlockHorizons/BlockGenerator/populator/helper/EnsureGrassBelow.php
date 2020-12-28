<?php

namespace BlockHorizons\BlockGenerator\populator\helper;

use pocketmine\block\Block;
use pocketmine\level\format\Chunk;

class EnsureGrassBelow
{

    private function __construct()
    {
    }

    public static function ensureGrassBelow(int $x, int $y, int $z, Chunk $chunk)
    {
        return EnsureBelow::ensureBelow($x, $y, $z, Block::GRASS, $chunk);
    }

}