<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\roofedforest;

use BlockHorizons\BlockGenerator\biomes\type\GrassyBiome;
//use BlockHorizons\BlockGenerator\populator\FlowerPopulator;
//use BlockHorizons\BlockGenerator\populator\MushroomPopulator;
//use BlockHorizons\BlockGenerator\populator\tree\DarkOakTreePopulator;

class RoofedForestBiome extends GrassyBiome
{

	public function __construct()
	{
		parent::__construct();

		// TODO
//		$tree = new DarkOakTreePopulator();
//		$tree->setBaseAmount(20);
//		$tree->setRandomAmount(10);
//		$this->addPopulator($tree);
//
//		$flower = new FlowerPopulator();
//		$flower->setBaseAmount(2);
//		$this->addPopulator($flower);
//
//		$mushroom = new MushroomPopulator();
//		$mushroom->setBaseAmount(0);
//		$mushroom->setRandomAmount(1);
//		$this->addPopulator($mushroom);
	}

	public function getName(): string
	{
		return "Roofed Forest";
	}

}
