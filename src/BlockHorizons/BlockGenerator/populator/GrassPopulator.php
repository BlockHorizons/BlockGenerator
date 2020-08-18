<?php
namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\populator\helper\PopulatorHelpers;
use pocketmine\block\Block;
use pocketmine\level\format\Chunk;
use pocketmine\utils\Random;

class GrassPopulator extends SurfaceBlockPopulator {
	
	protected function canStay(int $x, int $y, int $z, Chunk $chunk) : bool {
        return PopulatorHelpers::canGrassStay($x, $y, $z, $chunk);
    }

    protected function getBlockId(int $x, int $z, Random $random, Chunk $chunk) : int {
        return Block::TALL_GRASS;
    }

}