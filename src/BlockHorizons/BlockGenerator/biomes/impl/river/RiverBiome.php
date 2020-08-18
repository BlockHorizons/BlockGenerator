<?php
namespace BlockHorizons\BlockGenerator\biomes\impl\river;

use BlockHorizons\BlockGenerator\biomes\type\WateryBiome;

class RiverBiome extends WateryBiome {
	
	public function __construct() {
		parent::__construct();

        $this->setBaseHeight(-0.5);
        $this->setHeightVariation(0);
    }

    public function getName() : string {
        return "River";
    }

}