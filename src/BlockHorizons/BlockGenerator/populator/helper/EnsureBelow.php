<?php

namespace BlockHorizons\BlockGenerator\populator\helper;

use pocketmine\level\format\Chunk;

class EnsureBelow
{

    private function __construct()
    {
    }

    public static function ensureBelow(int $x, int $y, int $z, int $id, Chunk $chunk): bool
    {
        return $chunk->getBlockId($x, $y - 1, $z) === $id;
    }

}