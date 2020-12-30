<?php

namespace BlockHorizons\BlockGenerator\biomes\impl\plains;

use BlockHorizons\BlockGenerator\populator\DoublePlantPopulator;

class SunflowerPlainsBiome extends PlainsBiome
{

    public function __construct()
    {
        parent::__construct();

        $sunflower = new DoublePlantPopulator(0);
        $sunflower->setBaseAmount(8);
        $sunflower->setRandomAmount(5);
        $this->addPopulator($sunflower);
    }

    public function getName(): string
    {
        return "Sunflower Plains";
    }
}