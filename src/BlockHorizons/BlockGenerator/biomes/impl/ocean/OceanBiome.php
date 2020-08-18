<?php
namespace BlockHorizons\BlockGenerator\biomes\impl\ocean;

use BlockHorizons\BlockGenerator\biomes\type\WateryBiome;

class OceanBiome extends WateryBiome {

    public function __construct() {
    	parent::__construct();

        $this->setBaseHeight(-1);
        $this->setHeightVariation(0.1);
    }

    public function getName() : string {
        return "Ocean";
    }
    
}
