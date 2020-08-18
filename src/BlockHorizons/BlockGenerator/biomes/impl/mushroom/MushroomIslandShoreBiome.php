<?php
namespace BlockHorizons\BlockGenerator\biomes\impl\mushroom;

class MushroomIslandShoreBiome extends MushroomIslandBiome {
    
    public function __construct() {
        parent::__construct();

        $this->setBaseHeight(0);
        $this->setHeightVariation(0.025);
    }

    public function getName() : string {
        return "Mushroom Island Shore";
    }
}
