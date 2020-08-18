<?php
namespace BlockHorizons\BlockGenerator\biomes\impl\desert;

use BlockHorizons\BlockGenerator\biomes\type\SandyBiome;
use BlockHorizons\BlockGenerator\populator\CactusPopulator;
use BlockHorizons\BlockGenerator\populator\DeadBushPopulator;

class DesertHillsBiome extends SandyBiome {

    public function __construct() {
        parent::__construct();

        $this->setBaseHeight(0.45);
        $this->setHeightVariation(0.3);
    }

    public function getName() : string {
        return "Desert Hills";
    }

}