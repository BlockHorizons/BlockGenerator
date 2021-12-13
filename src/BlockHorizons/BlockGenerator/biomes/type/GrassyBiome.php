<?php

namespace BlockHorizons\BlockGenerator\biomes\type;

use BlockHorizons\BlockGenerator\populator\GrassPopulator;
use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;
use pocketmine\world\generator\populator\TallGrass;

abstract class GrassyBiome extends CoveredBiome
{

	public function __construct()
	{
		parent::__construct();

		$grass = new GrassPopulator();
		$grass->setBaseAmount(30);
		$this->addPopulator($grass);

//		$tallGrass = new TallGrass();
//		$tallGrass->setBaseAmount(30);
//		$this->addPopulator($tallGrass);
	}

	public function getSurfaceBlock(int $y): Block
	{
		return VanillaBlocks::GRASS();
	}

	public function getGroundBlock(int $y): Block
	{
		return VanillaBlocks::DIRT();
	}

}