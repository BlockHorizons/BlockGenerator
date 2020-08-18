<?php
namespace BlockHorizons\BlockGenerator\biomes\impl\desert;

class DesertMBiome extends DesertBiome {

    public function __construct() {
        parent::__construct();

        $this->setBaseHeight(0.225);
        $this->setHeightVariation(0.25);
    }

    public function getName() : string {
        return "Desert M";
    }

}