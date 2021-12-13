<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\taiga;


class MegaTaigaHillsBiome extends MegaTaigaBiome
{

	public function __construct()
	{
		parent::__construct();

		$this->setBaseHeight(0.45);
		$this->setHeightVariation(0.3);
	}

	public function getName(): string
	{
		return "Mega Taiga Hills";
	}
}
