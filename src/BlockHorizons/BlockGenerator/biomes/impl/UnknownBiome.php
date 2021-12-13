<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl;

use BlockHorizons\BlockGenerator\biomes\CustomBiome;

class UnknownBiome extends CustomBiome
{
    public function getName(): string
    {
        return "unknown";
    }

    public function getId(): int
	{
		return 0;
	}
}