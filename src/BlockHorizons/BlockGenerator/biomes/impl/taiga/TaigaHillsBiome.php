<?php

namespace BlockHorizons\BlockGenerator\biomes\impl\taiga;

use BlockHorizons\BlockGenerator\biomes\type\GrassyBiome;


class TaigaHillsBiome extends GrassyBiome
{

    public function __construct()
    {
        parent::__construct();

        $this->setBaseHeight(0.25);
        $this->setHeightVariation(0.8);
    }

    public function getName(): string
    {
        return "Taiga Hills";
    }
}
