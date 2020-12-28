<?php

namespace BlockHorizons\BlockGenerator\biomes\impl\beach;

use BlockHorizons\BlockGenerator\biomes\type\SandyBiome;
use BlockHorizons\BlockGenerator\populator\SugarcanePopulator;

class BeachBiome extends SandyBiome
{

    public function __construct()
    {

        $sugarcane = new SugarcanePopulator();
        $sugarcane->setBaseAmount(8);
        $sugarcane->setRandomAmount(5);

        $this->addPopulator($sugarcane);

        $this->setBaseHeight(0.0);
        $this->setHeightVariation(0.025);
    }

    public function getName(): string
    {
        return "Beach";

    }

}