<?php

namespace BlockHorizons\BlockGenerator\biomes\impl\taiga;


class ColdTaigaMBiome extends TaigaBiome
{

    public function getName(): string
    {
        return "Cold Taiga M";
    }

    public function doesOverhand(): bool
    {
        return true;
    }

}
