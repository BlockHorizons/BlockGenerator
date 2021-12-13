<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\beach;

use BlockHorizons\BlockGenerator\biomes\type\SandyBiome;
use BlockHorizons\BlockGenerator\populator\WaterIcePopulator;
use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;

class ColdBeachBiome extends SandyBiome
{

	public function __construct()
	{
		parent::__construct();

		$ice = new WaterIcePopulator();
		$this->addPopulator($ice);

		$this->setBaseHeight(0);
		$this->setHeightVariation(0.025);
	}

	public function getCoverBlock(int $y): Block
	{
		return VanillaBlocks::SNOW_LAYER();
	}

	public function getName(): string
	{
		return "Cold Beach";
	}

	public function isFreezing(): bool
	{
		return true;
	}

}