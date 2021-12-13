<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\mushroom;

use BlockHorizons\BlockGenerator\biomes\type\GrassyBiome;
use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;

class MushroomIslandBiome extends GrassyBiome
{

	public function __construct()
	{
		parent::__construct();

		// TODo
//		$mushroomPopulator = new MushroomPopulator();
//		$mushroomPopulator->setBaseAmount(1);
//		$this->addPopulator($mushroomPopulator);

		$this->setBaseHeight(0.2);
		$this->setHeightVariation(0.3);
	}

	public function getName(): string
	{
		return "Mushroom Island";
	}

	public function getSurfaceBlock(int $y): Block
	{
		return VanillaBlocks::MYCELIUM();
	}
}
