<?php
namespace BlockHorizons\BlockGenerator\biomes\impl\taiga;

use BlockHorizons\BlockGenerator\populator\SpruceBigTreePopulator;

class MegaSpruceTaigaBiome extends MegaTaigaBiome {

    public function __construct() {
        parent::__construct();

        $bigTrees = new SpruceBigTreePopulator();
        $bigTrees->setBaseAmount(6);
        $bigTrees->setRandomAmount(30); // invalid
        $this->addPopulator($bigTrees);
    }

    public function getName() : string {
        return "Mega Spruce Taiga";
    }
}
