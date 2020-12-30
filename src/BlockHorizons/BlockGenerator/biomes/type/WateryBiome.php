<?php

namespace BlockHorizons\BlockGenerator\biomes\type;

use pocketmine\block\Block;

abstract class WateryBiome extends CoveredBiome
{

    public function getSurfaceDepth(int $y): int
    {
        return 0;
    }

    public function getSurfaceBlock(int $y): int
    {
        //doesn't matter, surface depth is 0
        return 0;
    }

    public function getGroundDepth(int $y): int
    {
        return 5;
    }

    public function getGroundBlock(int $y): int
    {
        return Block::SAND;
    }

}