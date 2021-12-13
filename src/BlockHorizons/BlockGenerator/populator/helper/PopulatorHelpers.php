<?php

namespace BlockHorizons\BlockGenerator\populator\helper;

use pocketmine\block\Block;
use pocketmine\block\BlockLegacyIds;
use pocketmine\world\ChunkManager;
use pocketmine\world\format\Chunk;

class PopulatorHelpers
{

	const NON_SOLID = [
		BlockLegacyIds::AIR => true,
		BlockLegacyIds::LEAVES => true,
		BlockLegacyIds::LEAVES2 => true,
		BlockLegacyIds::SNOW_LAYER => false,
		BlockLegacyIds::TALL_GRASS => true,
	];

	private function __construct()
	{
	}

	public static function canGrassStay(ChunkManager $world, int $x, int $y, int $z): bool
	{
		return EnsureCover::ensureCover($x, $y, $z, $world) && EnsureGrassBelow::ensureGrassBelow($x, $y, $z, $world);
	}

	public static function isNonSolid(int $id): bool
	{
		return self::NON_SOLID[$id] ?? false;
	}

}