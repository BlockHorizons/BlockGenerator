<?php
namespace BlockHorizons\BlockGenerator\biomes\impl\beach;

use BlockHorizons\BlockGenerator\biomes\type\SandyBiome;
use BlockHorizons\BlockGenerator\populator\SugarcanePopulator;
use BlockHorizons\BlockGenerator\populator\WaterIcePopulator;
use pocketmine\block\Block;

class ColdBeachBiome extends SandyBiome {

	public function __construct() {
        $ice = new WaterIcePopulator();
        $this->addPopulator($ice);

        $this->setBaseHeight(0);
        $this->setHeightVariation(0.025);
    }

    public function getCoverBlock(int $y) : int {
        return Block::SNOW_LAYER << 4;
    }

    public function getName() : string {
        return "Cold Beach";
    }

    public function isFreezing() : bool {
        return true;
    }

}