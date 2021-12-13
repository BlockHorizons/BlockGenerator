<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\savanna;

use BlockHorizons\BlockGenerator\biomes\type\GrassyBiome;
use BlockHorizons\BlockGenerator\populator\TreePopulator;
use pocketmine\block\utils\TreeType;

class SavannaBiome extends GrassyBiome
{

	public function __construct()
	{
		parent::__construct();

		$tree = new TreePopulator(TreeType::ACACIA());
		$tree->setBaseAmount(1);
		$this->addPopulator($tree);

		$this->setBaseHeight(0.125);
		$this->setHeightVariation(0.05);
	}

	public function getName(): string
	{
		return "Savanna";
	}
}
