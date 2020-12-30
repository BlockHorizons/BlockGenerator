<?php

namespace BlockHorizons\BlockGenerator\biomes\impl\taiga;

use BlockHorizons\BlockGenerator\populator\SpruceBigTreePopulator;


class MegaTaigaBiome extends TaigaBiome
{

    public function __construct()
    {
        parent::__construct();

        $bigTrees = new SpruceBigTreePopulator();
        $bigTrees->setBaseAmount(4);
        $bigTrees->setRandomAmount(6);

        $this->addPopulator($bigTrees);

        $this->setBaseHeight(0.2);
        $this->setHeightVariation(0.2);
    }

    public function getName(): string
    {
        return "Mega Taiga";
    }

}
