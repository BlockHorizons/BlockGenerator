<?php
namespace BlockHorizons\BlockGenerator\biomes\type;

use pocketmine\block\Block;

abstract class SandyBiome extends CoveredBiome {

    public function getSurfaceDepth(int $y) : int {
        return 3;
    }

    public function getSurfaceBlock(int $y) : int {
        return Block::SAND;
    }

    public function getGroundDepth(int $y) : int {
        return 2;
    }

    public function getGroundBlock(int $y) : int {
        return Block::SANDSTONE;
    }

}