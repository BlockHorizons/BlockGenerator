<?php

namespace BlockHorizons\BlockGenerator\biomes\impl\ocean;

use BlockHorizons\BlockGenerator\populator\WaterIcePopulator;

class FrozenOceanBiome extends OceanBiome
{

    public function __construct()
    {
        parent::__construct();

        $ice = new WaterIcePopulator();
        $this->addPopulator($ice);
    }

    public function getName(): string
    {
        return "Frozen Ocean";
    }

    public function isFreezing(): bool
    {
        return true;
    }
}
