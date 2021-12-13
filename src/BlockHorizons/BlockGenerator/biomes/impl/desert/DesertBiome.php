<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\desert;

use BlockHorizons\BlockGenerator\biomes\type\SandyBiome;
use BlockHorizons\BlockGenerator\populator\CactusPopulator;
use BlockHorizons\BlockGenerator\populator\DeadBushPopulator;

class DesertBiome extends SandyBiome
{

	public function __construct()
	{
		parent::__construct();

		$cactus = new CactusPopulator();
		$cactus->setBaseAmount(1);
		$this->addPopulator($cactus);

		$deadbush = new DeadBushPopulator();
		$deadbush->setBaseAmount(1);
		$this->addPopulator($deadbush);

		$this->setBaseHeight(0.125);
		$this->setHeightVariation(0.05);
	}

	public function getName(): string
	{
		return "Desert";
	}

}