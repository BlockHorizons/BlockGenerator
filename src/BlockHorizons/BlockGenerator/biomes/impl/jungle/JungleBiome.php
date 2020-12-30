<?php

namespace BlockHorizons\BlockGenerator\biomes\impl\jungle;

use BlockHorizons\BlockGenerator\biomes\type\GrassyBiome;
use BlockHorizons\BlockGenerator\populator\MelonPopulator;
use BlockHorizons\BlockGenerator\populator\tree\BigJungleTreePopulator;
use BlockHorizons\BlockGenerator\populator\tree\JungleTreePopulator;

class JungleBiome extends GrassyBiome
{

    public function __construct()
    {
        parent::__construct();

        $trees = new JungleTreePopulator();
        $trees->setBaseAmount(10);
        $this->addPopulator($trees);

        $bigTrees = new BigJungleTreePopulator();
        $bigTrees->setBaseAmount(6);
        $this->addPopulator($bigTrees);

        $melon = new MelonPopulator();
        $melon->setBaseAmount(-65);
        $melon->setRandomAmount(70);
        $this->addPopulator($melon);
    }

    public function getName(): string
    {
        return "Jungle";
    }
}
