<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\populator\helper;

use pocketmine\world\ChunkManager;

class EnsureCover
{

	private function __construct()
	{
	}

	public static function ensureCover(int $x, int $y, int $z, ChunkManager $world): bool
	{
		return $world->getBlockAt($x, $y, $z)->canBeReplaced();
	}

}