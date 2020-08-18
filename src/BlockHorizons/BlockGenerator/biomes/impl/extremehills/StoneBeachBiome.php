<?php
namespace BlockHorizons\BlockGenerator\biomes\impl\extremehills;

use BlockHorizons\BlockGenerator\biomes\type\CoveredBiome;

class StoneBeachBiome extends CoveredBiome {
    
    public function __construct() {
        $this->setBaseHeight(0.1);
        $this->setHeightVariation(0.8);
    }

    public function getSurfaceDepth(int $y) : int {
        return 0;
    }

    public function getSurfaceBlock(int $y) : int {
        return 0;
    }

    public function getGroundDepth(int $y) : int {
        return 0;
    }

    public function getGroundBlock(int $y) : int {
        return 0;
    }

    public function getName() : string {
        return "Stone Beach";
    }
    
}
