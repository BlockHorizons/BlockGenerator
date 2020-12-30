<?php

namespace BlockHorizons\BlockGenerator\biomes\impl\savanna;

use BlockHorizons\BlockGenerator\biomes\type\GrassyBiome;
use BlockHorizons\BlockGenerator\populator\TreePopulator;


class SavannaBiome extends GrassyBiome
{

    public function __construct()
    {
        parent::__construct();

        $tree = new TreePopulator(\pocketmine\block\Wood2::ACACIA);
        $tree->setBaseAmount(1);
        $this->addPopulator($tree);

        $this->setBaseHeight(0.125);
        $this->setHeightVariation(0.05);
    }

    public function getName(): string
    {
        return "Savanna";
    }
}
