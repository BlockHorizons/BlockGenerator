<?php
namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\populator\SurfaceBlockPopulator;
use BlockHorizons\BlockGenerator\populator\helper\EnsureCover;
use BlockHorizons\BlockGenerator\populator\helper\EnsureGrassBelow;
use BlockHorizons\BlockGenerator\populator\helper\PopulatorHelpers;
use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\level\format\Chunk;
use pocketmine\utils\Random;

class DoublePlantPopulator extends SurfaceBlockPopulator {
	
	private $type;

    public function __construct(int $type)    {
        $this->type = $type;
    }

    protected function canStay(int $x, int $y, int $z, Chunk $chunk) : bool {
        return EnsureCover::ensureCover($x, $y, $z, $chunk) && EnsureCover::ensureCover($x, $y + 1, $z, $chunk) && EnsureGrassBelow::ensureGrassBelow($x, $y, $z, $chunk);
    }

    protected function getBlockId(int $x, int $z, Random $random, Chunk $chunk) : int {
        return Block::DOUBLE_PLANT;
    }

    protected function placeBlock(int $x, int $y, int $z, int $id, Chunk $chunk, Random $random) : void {
        $chunk->setBlock($x, $y, $z, $id, $this->type);
        $chunk->setBlock($x, $y + 1, $z, $id, $this->type);
    }

}