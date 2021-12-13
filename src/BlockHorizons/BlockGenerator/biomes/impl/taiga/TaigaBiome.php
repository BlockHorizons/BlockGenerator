<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\taiga;

use BlockHorizons\BlockGenerator\biomes\type\GrassyBiome;
use BlockHorizons\BlockGenerator\populator\TreePopulator;
use pocketmine\block\utils\TreeType;

class TaigaBiome extends GrassyBiome
{

	public function __construct()
	{
		parent::__construct();

		$trees = new TreePopulator(TreeType::SPRUCE());
		$trees->setBaseAmount(10);
		$trees->setRandomAmount(5);
		$this->addPopulator($trees);

		$this->setBaseHeight(0.2);
		$this->setHeightVariation(0.2);
	}

	public function getName(): string
	{
		return "Taiga";
	}
}
