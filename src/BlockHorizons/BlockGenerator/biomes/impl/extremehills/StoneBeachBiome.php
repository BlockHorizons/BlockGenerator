<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\extremehills;

use BlockHorizons\BlockGenerator\biomes\type\CoveredBiome;
use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;

class StoneBeachBiome extends CoveredBiome
{

	public function __construct()
	{
		parent::__construct();

		$this->setBaseHeight(0.1);
		$this->setHeightVariation(0.8);
	}

	public function getSurfaceDepth(int $y): int
	{
		return 0;
	}

	public function getSurfaceBlock(int $y): Block
	{
		return VanillaBlocks::AIR();
	}

	public function getGroundDepth(int $y): int
	{
		return 0;
	}

	public function getGroundBlock(int $y): Block
	{
		return VanillaBlocks::AIR();
	}

	public function getName(): string
	{
		return "Stone Beach";
	}

}
