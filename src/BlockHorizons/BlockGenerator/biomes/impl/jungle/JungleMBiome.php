<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\jungle;

//use BlockHorizons\BlockGenerator\populator\tree\JungleFloorPopulator;

class JungleMBiome extends JungleBiome
{

	public function __construct()
	{
		parent::__construct();

		// TODO
//		$floor = new JungleFloorPopulator();
//		$floor->setBaseAmount(10);
//		$floor->setRandomAmount(5);
//		$this->addPopulator($floor);

		$this->setBaseHeight(0.2);
		$this->setHeightVariation(0.4);
	}

	public function getName(): string
	{
		return "Jungle M";
	}
}
