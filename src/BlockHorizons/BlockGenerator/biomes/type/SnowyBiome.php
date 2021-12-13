<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\type;

use BlockHorizons\BlockGenerator\generators\BlockGenerator;
use BlockHorizons\BlockGenerator\populator\WaterIcePopulator;
use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;

abstract class SnowyBiome extends GrassyBiome
{

	public function __construct()
	{
		parent::__construct();

		$waterIce = new WaterIcePopulator();
		$this->addPopulator($waterIce);
	}

	public function getCoverBlock(int $y): Block
	{
		if ($y < BlockGenerator::SEA_HEIGHT) {
			return parent::getCoverBlock($y);
		}
		return VanillaBlocks::SNOW_LAYER();
	}

	public function isFreezing(): bool
	{
		return true;
	}

}