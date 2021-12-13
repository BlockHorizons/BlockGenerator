<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\plains;

use BlockHorizons\BlockGenerator\biomes\CustomBiome;
use BlockHorizons\BlockGenerator\biomes\type\GrassyBiome;
use BlockHorizons\BlockGenerator\populator\FlowerPopulator;
use pocketmine\block\VanillaBlocks;

class PlainsBiome extends GrassyBiome
{

	public function __construct()
	{
		parent::__construct();

		$this->setBaseHeight(0.175);
		$this->setHeightVariation(0.05);

		$flower = new FlowerPopulator();
		$flower->setBaseAmount(10);
		$flower->addType(VanillaBlocks::DANDELION());
		$flower->addType(VanillaBlocks::POPPY());
		$flower->addType(VanillaBlocks::ALLIUM());
		$flower->addType(VanillaBlocks::SUNFLOWER());
		$flower->addType(VanillaBlocks::LILAC());
		$flower->addType(VanillaBlocks::ROSE_BUSH());
		$this->addPopulator($flower);
	}

	public function getName(): string
	{
		return "Plains";
	}

	public function getId(): int
	{
		return CustomBiome::PLAINS;
	}

}