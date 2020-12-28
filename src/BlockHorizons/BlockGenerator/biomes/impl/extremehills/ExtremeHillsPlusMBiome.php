<?php

namespace BlockHorizons\BlockGenerator\biomes\impl\extremehills;

class ExtremeHillsPlusMBiome extends ExtremeHillsMBiome
{

    public function __construct()
    {
        parent::__construct(false);

        $this->setBaseHeight(2);
        $this->setHeightVariation(1.2);
    }

    public function getName(): string
    {
        return "Extreme Hills+ M";
    }

    public function doesOverhang(): bool
    {
        return false;
    }
}
