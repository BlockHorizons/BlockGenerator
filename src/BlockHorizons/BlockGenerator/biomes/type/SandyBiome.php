<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\type;

use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;

abstract class SandyBiome extends CoveredBiome
{

	public function getSurfaceDepth(int $y): int
	{
		return 3;
	}

	public function getSurfaceBlock(int $y): Block
	{
		return VanillaBlocks::SAND();
	}

	public function getGroundDepth(int $y): int
	{
		return 2;
	}

	public function getGroundBlock(int $y): Block
	{
		return VanillaBlocks::SANDSTONE();
	}

}