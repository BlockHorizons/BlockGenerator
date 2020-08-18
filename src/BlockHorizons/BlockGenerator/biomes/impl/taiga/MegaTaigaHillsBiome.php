<?php
namespace BlockHorizons\BlockGenerator\biomes\impl\taiga;

use BlockHorizons\BlockGenerator\biomes\type\GrassyBiome;
use BlockHorizons\BlockGenerator\populator\TreePopulator;


class MegaTaigaHillsBiome extends MegaTaigaBiome {

    public function __construct() {
        parent::__construct();

        $this->setBaseHeight(0.45);
        $this->setHeightVariation(0.3);
    }

    public function getName() : string {
        return "Mega Taiga Hills";
    }
}
