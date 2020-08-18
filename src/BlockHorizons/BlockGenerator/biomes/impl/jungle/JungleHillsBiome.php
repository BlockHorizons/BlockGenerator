<?php
namespace BlockHorizons\BlockGenerator\biomes\impl\jungle;

class JungleHillsBiome extends JungleBiome {
    
    public function __construct() {
        parent::__construct();

        $this->setBaseHeight(0.45);
        $this->setHeightVariation(0.3);
    }

    public function getName() : string {
        return "Jungle Hills";
    }
    
}
