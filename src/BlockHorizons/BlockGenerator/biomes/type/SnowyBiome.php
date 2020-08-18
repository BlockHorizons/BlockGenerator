<?php
namespace BlockHorizons\BlockGenerator\biomes\type;

use BlockHorizons\BlockGenerator\biomes\type\GrassyBiome;
use BlockHorizons\BlockGenerator\populator\WaterIcePopulator;
use pocketmine\block\Block;

abstract class SnowyBiome extends GrassyBiome {
    
    public function __construct() {
        parent::__construct();

        $waterIce = new WaterIcePopulator();
        $this->addPopulator($waterIce);
    }

    public function getCoverBlock(int $y) : int {
        return Block::SNOW_LAYER << 4;
    }

}