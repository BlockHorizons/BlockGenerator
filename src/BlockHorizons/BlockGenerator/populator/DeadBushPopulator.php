<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\populator\helper\EnsureBelow;
use BlockHorizons\BlockGenerator\populator\helper\EnsureCover;
use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;
use pocketmine\utils\Random;
use pocketmine\world\ChunkManager;

class DeadBushPopulator extends SurfaceBlockPopulator
{

	protected function canStay(int $x, int $y, int $z, ChunkManager $world): bool
	{
		return EnsureCover::ensureCover($x, $y, $z, $world) && EnsureBelow::ensureBelow($x, $y, $z, VanillaBlocks::SAND(), $world);
	}

	protected function getBlock(int $x, int $z, Random $random, ChunkManager $world): Block
	{
		return VanillaBlocks::DEAD_BUSH();
	}
}