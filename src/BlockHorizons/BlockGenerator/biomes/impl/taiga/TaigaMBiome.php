<?php
namespace BlockHorizons\BlockGenerator\biomes\impl\taiga;

use BlockHorizons\BlockGenerator\biomes\type\GrassyBiome;
use BlockHorizons\BlockGenerator\populator\TreePopulator;


class TaigaMBiome extends GrassyBiome {

    public function __construct() {
        parent::__construct();

        $this->setBaseHeight(0.3);
        $this->setHeightVariation(0.4);
    }

    public function getName() : string {
        return "Taiga M";
    }

}
