<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\savanna;

class SavannaPlateauBiome extends SavannaBiome
{

	public function __construct()
	{
		parent::__construct();

		$this->setBaseHeight(1.5);
		$this->setHeightVariation(0.025);
	}

	public function getName(): string
	{
		return "Savanna Plateau";
	}
}
