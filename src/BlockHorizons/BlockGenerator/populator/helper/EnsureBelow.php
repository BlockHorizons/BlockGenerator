<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\populator\helper;

use pocketmine\block\Block;
use pocketmine\world\ChunkManager;

class EnsureBelow
{

	private function __construct()
	{
	}

	public static function ensureBelow(int $x, int $y, int $z, Block $block, ChunkManager $world): bool
	{
		return $world->getBlockAt($x, $y - 1, $z)->getId() === $block->getId();
	}

}