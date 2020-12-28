<?php

namespace BlockHorizons\BlockGenerator\biomes\impl\mesa;

class MesaBryceBiome extends MesaBiome
{

    public function getName(): string
    {
        return "Mesa (Bryce)";
    }

    protected function getMoundFrequency(): float
    {
        return 1 / 16;
    }

    protected function minHill(): float
    {
        return 0.3;
    }

}
