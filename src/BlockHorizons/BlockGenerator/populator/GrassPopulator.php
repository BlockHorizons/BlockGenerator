<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\populator\helper\PopulatorHelpers;
use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;
use pocketmine\utils\Random;
use pocketmine\world\ChunkManager;

class GrassPopulator extends SurfaceBlockPopulator
{

	protected function canStay(int $x, int $y, int $z, ChunkManager $world): bool
	{
		return PopulatorHelpers::canGrassStay($world, $x, $y, $z);
	}

	protected function getBlock(int $x, int $z, Random $random, ChunkManager $world): Block
	{
		return VanillaBlocks::TALL_GRASS();
	}
}