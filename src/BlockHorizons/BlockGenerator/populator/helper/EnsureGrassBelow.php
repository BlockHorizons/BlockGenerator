<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\populator\helper;

use pocketmine\block\VanillaBlocks;
use pocketmine\world\ChunkManager;
use pocketmine\world\format\Chunk;

class EnsureGrassBelow
{

	private function __construct()
	{
	}

	public static function ensureGrassBelow(int $x, int $y, int $z, ChunkManager $world): bool
	{
		return EnsureBelow::ensureBelow($x, $y, $z, VanillaBlocks::GRASS(), $world);
	}

}