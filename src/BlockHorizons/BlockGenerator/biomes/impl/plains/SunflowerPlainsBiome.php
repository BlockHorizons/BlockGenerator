<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\plains;

use BlockHorizons\BlockGenerator\populator\DoublePlantPopulator;
use pocketmine\block\VanillaBlocks;

class SunflowerPlainsBiome extends PlainsBiome
{

	public function __construct()
	{
		parent::__construct();

		$sunflower = new DoublePlantPopulator(VanillaBlocks::SUNFLOWER());
		$sunflower->setBaseAmount(8);
		$sunflower->setRandomAmount(5);
		$this->addPopulator($sunflower);
	}

	public function getName(): string
	{
		return "Sunflower Plains";
	}
}