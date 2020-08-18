<?php
namespace BlockHorizons\BlockGenerator\biomes\impl\roofedforest;

use BlockHorizons\BlockGenerator\biomes\type\GrassyBiome;
use BlockHorizons\BlockGenerator\populator\FlowerPopulator;
use BlockHorizons\BlockGenerator\populator\MushroomPopulator;
use BlockHorizons\BlockGenerator\populator\tree\DarkOakTreePopulator;

class RoofedForestMBiome extends GrassyBiome {

    public function __construct() {
        parent::__construct();

        $this->setBaseHeight(0.2);
        $this->setHeightVariation(0.4);
    }

    public function getName() : string {
        return "Roofed Forest M";
    }

}
