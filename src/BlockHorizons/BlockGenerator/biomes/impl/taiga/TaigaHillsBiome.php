<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\taiga;


class TaigaHillsBiome extends TaigaBiome
{

	public function __construct()
	{
		parent::__construct();

		$this->setBaseHeight(0.25);
		$this->setHeightVariation(0.8);
	}

	public function getName(): string
	{
		return "Taiga Hills";
	}
}
