<?php
namespace BlockHorizons\BlockGenerator\biomes\impl\mesa;

use BlockHorizons\BlockGenerator\populator\TreePopulator;
use pocketmine\block\Block;


class MesaPlateauFBiome extends MesaPlateauBiome {

	public function __construct() {
		parent::__construct();

        $tree = new TreePopulator(\pocketmine\block\Wood::OAK);
        $tree->setBaseAmount(2);
        $tree->setRandomAmount(1);
        $this->addPopulator($tree);
    }

    public function getCoverBlock(int $y) : int {
        return Block::GRASS;
    }

    public function getName() : string {
        return "Mesa Plateau F";
    }

}
