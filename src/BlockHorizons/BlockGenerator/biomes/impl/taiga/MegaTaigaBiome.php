<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\taiga;

use BlockHorizons\BlockGenerator\populator\TreePopulator;
use pocketmine\block\utils\TreeType;


class MegaTaigaBiome extends TaigaBiome
{

	public function __construct()
	{
		parent::__construct();

		$bigTrees = new TreePopulator(TreeType::SPRUCE(), true);
		$bigTrees->setBaseAmount(6);
		$bigTrees->setRandomAmount(4);
		$this->addPopulator($bigTrees);

		$this->setBaseHeight(0.2);
		$this->setHeightVariation(0.2);
	}

	public function getName(): string
	{
		return "Mega Taiga";
	}

}
