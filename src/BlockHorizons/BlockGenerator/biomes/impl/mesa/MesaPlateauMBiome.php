<?php

namespace BlockHorizons\BlockGenerator\biomes\impl\mesa;

class MesaPlateauMBiome extends MesaBiome
{

    public function __construct()
    {
        parent::__construct();

        $this->setMoundHeight(10);
    }

    public function getName(): string
    {
        return "Mesa Plateau M";
    }

    protected function getMoundFrequency(): float
    {
        return 1 / 50;
    }

    protected function minHill(): float
    {
        return 0.1;
    }

}
