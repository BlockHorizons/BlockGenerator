<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\taiga;


class ColdTaigaMBiome extends ColdTaigaBiome
{

	public function getName(): string
	{
		return "Cold Taiga M";
	}

	public function doesOverhang(): bool
	{
		return true;
	}

}
