<?php
namespace BlockHorizons\BlockGenerator\biomes\impl\taiga;

use BlockHorizons\BlockGenerator\populator\WaterIcePopulator;
use pocketmine\block\Block;


class ColdTaigaMBiome extends TaigaBiome {
    
    public function getName() : string {
        return "Cold Taiga M";
    }

    public function doesOverhand() : bool {
        return true;
    }

}
