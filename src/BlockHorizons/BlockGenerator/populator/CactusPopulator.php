<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\populator\helper\EnsureBelow;
use BlockHorizons\BlockGenerator\populator\helper\EnsureCover;
use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;
use pocketmine\utils\Random;
use pocketmine\world\ChunkManager;

class CactusPopulator extends SurfaceBlockPopulator
{

	public function placeBlock(int $x, int $y, int $z, Block $block, ChunkManager $world, Random $random): void
	{
		$height = (int)(1 + (12 - 1) * abs(-2 + ($random->nextFloat() + $random->nextFloat() + $random->nextFloat() + $random->nextFloat())) / 2.0);

		for ($height = floor($height / 2) + 1; $height >= 0; $height--) {
			parent::placeBlock($x, (int)($y + $height), $z, $block, $world, $random);
		}
	}

	protected function canStay(int $x, int $y, int $z, ChunkManager $world): bool
	{
		return EnsureCover::ensureCover($x, $y, $z, $world) && EnsureBelow::ensureBelow($x, $y, $z, VanillaBlocks::SAND(), $world);
	}

	protected function getBlock(int $x, int $z, Random $random, ChunkManager $world): Block
	{
		return VanillaBlocks::CACTUS();
	}
}