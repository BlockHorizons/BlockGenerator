<?php

namespace BlockHorizons\BlockGenerator\biomes\impl\mushroom;

use BlockHorizons\BlockGenerator\biomes\type\GrassyBiome;
use BlockHorizons\BlockGenerator\populator\MushroomPopulator;
use pocketmine\block\Block;

class MushroomIslandBiome extends GrassyBiome
{

    public function __construct()
    {
        $mushroomPopulator = new MushroomPopulator();
        $mushroomPopulator->setBaseAmount(1);
        $this->addPopulator($mushroomPopulator);

        $this->setBaseHeight(0.2);
        $this->setHeightVariation(0.3);
    }

    public function getName(): string
    {
        return "Mushroom Island";
    }

    public function getSurfaceBlock(int $y): int
    {
        return Block::MYCELIUM;
    }
}
