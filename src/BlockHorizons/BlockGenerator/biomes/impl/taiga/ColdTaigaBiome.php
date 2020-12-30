<?php

namespace BlockHorizons\BlockGenerator\biomes\impl\taiga;

use BlockHorizons\BlockGenerator\populator\WaterIcePopulator;
use pocketmine\block\Block;


class ColdTaigaBiome extends TaigaBiome
{

    public function __construct()
    {
        parent::__construct();

        $ice = new WaterIcePopulator();
        $this->addPopulator($ice);

        $this->setBaseHeight(0.2);
        $this->setHeightVariation(0.2);
    }

    public function getName(): string
    {
        return "Cold Taiga";
    }

    public function getCoverBlock(int $y): int
    {
        return Block::SNOW_LAYER << 4;
    }

    public function isFreezing(): bool
    {
        return true;
    }
}
