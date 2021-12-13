<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\taiga;

use BlockHorizons\BlockGenerator\populator\WaterIcePopulator;
use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;


class ColdTaigaBiome extends TaigaBiome
{

	public function __construct()
	{
		parent::__construct();

		$ice = new WaterIcePopulator();
		$this->addPopulator($ice);

		$this->setBaseHeight(0.2);
		$this->setHeightVariation(0.2);
	}

	public function getName(): string
	{
		return "Cold Taiga";
	}

	public function getCoverBlock(int $y): Block
	{
		return VanillaBlocks::SNOW_LAYER();
	}

	public function isFreezing(): bool
	{
		return true;
	}
}
