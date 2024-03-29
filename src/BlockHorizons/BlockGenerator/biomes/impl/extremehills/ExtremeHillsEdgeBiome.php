<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\extremehills;


class ExtremeHillsEdgeBiome extends ExtremeHillsBiome
{

	public function __construct()
	{
		parent::__construct();

		$this->setBaseHeight(0.8);
		$this->setHeightVariation(0.3);
	}

	public function getName(): string
	{
		return "Extreme Hills Edge";
	}

}