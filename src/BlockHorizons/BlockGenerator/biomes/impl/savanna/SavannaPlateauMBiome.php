<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\savanna;

class SavannaPlateauMBiome extends SavannaPlateauBiome
{

	public function __construct()
	{
		parent::__construct();
		
		$this->setBaseHeight(1.05);
		$this->setHeightVariation(1.2125001);
	}

	public function getName(): string
	{
		return "Savanna Plateau M";
	}

	public function doesOverhang(): bool
	{
		return true;
	}

}
