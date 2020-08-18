<?php
namespace BlockHorizons\BlockGenerator\biomes\impl\plains;

use BlockHorizons\BlockGenerator\biomes\CustomBiome;
use BlockHorizons\BlockGenerator\biomes\type\GrassyBiome;
use BlockHorizons\BlockGenerator\populator\TreePopulator;
use pocketmine\block\Block;



class PlainsBiome extends GrassyBiome {

    public function __construct() {
        parent::__construct();

        $this->setBaseHeight(0.125);
        $this->setHeightVariation(0.05);
    }

    public function getName() : string {
        return "Plains";
    }

    public function getId() : int {
    	return CustomBiome::PLAINS;
    }

}