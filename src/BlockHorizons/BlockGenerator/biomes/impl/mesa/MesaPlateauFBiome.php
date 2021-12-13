<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\mesa;

use BlockHorizons\BlockGenerator\populator\TreePopulator;
use pocketmine\block\Block;
use pocketmine\block\utils\TreeType;
use pocketmine\block\VanillaBlocks;

class MesaPlateauFBiome extends MesaPlateauBiome
{

	public function __construct()
	{
		parent::__construct();

		$tree = new TreePopulator(TreeType::ACACIA()); // or oak? ehhh
		$tree->setBaseAmount(2);
		$tree->setRandomAmount(1);
		$this->addPopulator($tree);
	}

	public function getCoverBlock(int $y): Block
	{
		return VanillaBlocks::GRASS();
	}

	public function getName(): string
	{
		return "Mesa Plateau F";
	}

}
