<?php
namespace BlockHorizons\BlockGenerator\biomes\impl\extremehills;

use BlockHorizons\BlockGenerator\biomes\type\GrassyBiome;
use BlockHorizons\BlockGenerator\populator\TreePopulator;


class ExtremeHillsEdgeBiome extends ExtremeHillsBiome {

    public function __construct() {
        parent::__construct(true);

        $this->setBaseHeight(0.8);
        $this->setHeightVariation(0.3);
    }

    public function getName() : string {
        return "Extreme Hills Edge";
    }

}