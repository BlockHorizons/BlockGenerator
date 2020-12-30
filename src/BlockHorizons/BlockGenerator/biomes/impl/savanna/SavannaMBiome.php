<?php

namespace BlockHorizons\BlockGenerator\biomes\impl\savanna;

class SavannaMBiome extends SavannaBiome
{

    public function __construct()
    {
        parent::__construct();

        $this->setBaseHeight(0.3625);
        $this->setHeightVariation(1.225);
    }

    public function getName(): string
    {
        return "Savanna M";
    }

    public function doesOverhang(): bool
    {
        return true;
    }

}
