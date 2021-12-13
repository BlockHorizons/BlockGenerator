<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\forest;

use BlockHorizons\BlockGenerator\populator\FlowerPopulator;
use pocketmine\block\VanillaBlocks;

class FlowerForestBiome extends ForestBiome
{

	public function __construct(int $type = ForestBiome::TYPE_NORMAL)
	{
		parent::__construct($type);

		//see https://minecraft.gamepedia.com/Flower#Flower_biomes
		$flower = new FlowerPopulator();
		$flower->setBaseAmount(10);
		$flower->addType(VanillaBlocks::DANDELION());
		$flower->addType(VanillaBlocks::POPPY());
		$flower->addType(VanillaBlocks::ALLIUM());
		$flower->addType(VanillaBlocks::AZURE_BLUET());
		$flower->addType(VanillaBlocks::RED_TULIP());
		$flower->addType(VanillaBlocks::ORANGE_TULIP());
		$flower->addType(VanillaBlocks::WHITE_TULIP());
		$flower->addType(VanillaBlocks::PINK_TULIP());
		$flower->addType(VanillaBlocks::OXEYE_DAISY());
		$flower->addType(VanillaBlocks::SUNFLOWER());
		$flower->addType(VanillaBlocks::LILAC());
		$flower->addType(VanillaBlocks::ROSE_BUSH());
		$this->addPopulator($flower);

		$this->setHeightVariation(0.4);
	}

	public function getName(): string
	{
		return $this->type == self::TYPE_BIRCH ? "Birch Forest" : "Forest";
	}

}
