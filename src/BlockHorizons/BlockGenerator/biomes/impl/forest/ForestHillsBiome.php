<?php
namespace BlockHorizons\BlockGenerator\biomes\impl\forest;

use BlockHorizons\BlockGenerator\populator\TreePopulator;

class ForestHillsBiome extends ForestBiome {

    public function __construct(int $type = self::TYPE_NORMAL) {
        parent::__construct($type);

        $this->setBaseHeight(0.45);
        $this->setHeightVariation(0.3);
    }

    public function getName() : string {
        switch ($this->type) {
            case self::TYPE_BIRCH:
                return "Birch Forest Hills";
            case self::TYPE_BIRCH_TALL:
                return "Birch Forest Hills M";
            default:
                return "Forest Hills";
        }
    }

}
