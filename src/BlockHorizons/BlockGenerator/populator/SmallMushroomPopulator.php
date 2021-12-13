<?php

namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\populator\helper\EnsureCover;
use BlockHorizons\BlockGenerator\populator\helper\EnsureGrassBelow;
use pocketmine\block\Block;
use pocketmine\level\format\Chunk;
use pocketmine\utils\Random;

class SmallMushroomPopulator extends SurfaceBlockPopulator
{

	protected function canStay(int $x, int $y, int $z, Chunk $chunk): bool
	{
		return EnsureCover::ensureCover($x, $y, $z, $chunk) && EnsureGrassBelow::ensureGrassBelow($x, $y, $z, $chunk);
	}

	protected function getBlockId(int $x, int $z, Random $random, Chunk $chunk): int
	{
		return Block::BROWN_MUSHROOM;
	}

}