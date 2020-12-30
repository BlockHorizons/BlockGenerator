<?php

namespace BlockHorizons\BlockGenerator\biomes\impl\taiga;

use pocketmine\block\Block;


class ColdTaigaHillsBiome extends TaigaBiome
{

    public function __construct()
    {
        $this->setBaseHeight(0.45);
        $this->setHeightVariation(0.3);
    }

    public function getName(): string
    {
        return "Cold Taiga Hills";
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
