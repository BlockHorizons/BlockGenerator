<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\type;

use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;

abstract class WateryBiome extends CoveredBiome
{

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
		return 5;
	}

	public function getGroundBlock(int $y): Block
	{
		return VanillaBlocks::SAND();
	}

}