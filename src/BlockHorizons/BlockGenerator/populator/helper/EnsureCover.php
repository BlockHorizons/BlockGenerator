<?php

namespace BlockHorizons\BlockGenerator\populator\helper;

use pocketmine\block\Block;
use pocketmine\level\format\Chunk;

class EnsureCover
{

    private function __construct()
    {
    }

    public static function ensureCover(int $x, int $y, int $z, Chunk $chunk): bool
    {
        $id = $chunk->getBlockId($x, $y, $z);
        return Block::get($id)->canBeReplaced();
    }

}