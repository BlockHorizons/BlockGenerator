<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\ocean;

class DeepOceanBiome extends OceanBiome
{

	public function __construct()
	{
		parent::__construct();

		$this->setBaseHeight(-1.8);
		$this->setHeightVariation(0.1);
	}

	public function getName(): string
	{
		return "Deep Ocean";
	}
}
