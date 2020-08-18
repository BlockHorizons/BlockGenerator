<?php
namespace BlockHorizons\BlockGenerator\biomes\impl\savanna;

class SavannaPlateauBiome extends SavannaBiome {

    public function __construct() {
        $this->setBaseHeight(1.5);
        $this->setHeightVariation(0.025);
    }

    public function getName() : string {
        return "Savanna Plateau";
    }
}
