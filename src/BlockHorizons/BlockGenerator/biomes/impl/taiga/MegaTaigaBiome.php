<?php
namespace BlockHorizons\BlockGenerator\biomes\impl\taiga;

use BlockHorizons\BlockGenerator\biomes\type\GrassyBiome;
use BlockHorizons\BlockGenerator\populator\SpruceBigTreePopulator;
use BlockHorizons\BlockGenerator\populator\TreePopulator;
use pocketmine\block\Block;


class MegaTaigaBiome extends TaigaBiome {

    public function __construct() {
        parent::__construct();

        $bigTrees = new SpruceBigTreePopulator();
        $bigTrees->setBaseAmount(6);
        $bigTrees->setRandomAmount(10);

        $this->addPopulator($bigTrees);

        $this->setBaseHeight(0.2);
        $this->setHeightVariation(0.2);
    }

    public function getName() : string {
        return "Mega Taiga";
    }
    
}
