<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\populator\helper\EnsureCover;
use BlockHorizons\BlockGenerator\populator\helper\EnsureGrassBelow;
use pocketmine\block\Block;
use pocketmine\block\DoublePlant;
use pocketmine\utils\Random;
use pocketmine\world\ChunkManager;

class DoublePlantPopulator extends SurfaceBlockPopulator
{

	public function __construct(
		protected DoublePlant $plant
	)
	{
	}

	protected function canStay(int $x, int $y, int $z, ChunkManager $world): bool
	{
		return EnsureCover::ensureCover($x, $y, $z, $world) && EnsureCover::ensureCover($x, $y + 1, $z, $world) && EnsureGrassBelow::ensureGrassBelow($x, $y, $z, $world);
	}

	protected function placeBlock(int $x, int $y, int $z, Block $block, ChunkManager $world, Random $random): void
	{
		if (!$block instanceof DoublePlant) {
			return;
		}

		$world->setBlockAt($x, $y, $z, $block);
		$world->setBlockAt($x, $y + 1, $z, (clone $block)->setTop(true));
	}

	protected function getBlock(int $x, int $z, Random $random, ChunkManager $world): DoublePlant
	{
		return $this->plant;
	}
}