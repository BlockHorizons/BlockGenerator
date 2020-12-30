<?php

namespace BlockHorizons\BlockGenerator\biomes\impl\desert;

class DesertHillsBiome extends DesertBiome
{

    public function __construct()
    {
        parent::__construct();

        $this->setBaseHeight(0.45);
        $this->setHeightVariation(0.3);
    }

    public function getName(): string
    {
        return "Desert Hills";
    }

}