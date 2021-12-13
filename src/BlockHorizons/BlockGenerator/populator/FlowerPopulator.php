<?php

namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\populator\helper\EnsureCover;
use BlockHorizons\BlockGenerator\populator\helper\EnsureGrassBelow;
use pocketmine\block\Block;
use pocketmine\block\DoublePlant;
use pocketmine\block\VanillaBlocks;
use pocketmine\utils\Random;
use pocketmine\world\ChunkManager;

class FlowerPopulator extends SurfaceBlockPopulator
{

	/**
	 * @var Block[]
	 */
	protected array $flowerTypes = [];

	public function addType(Block $flower): void
	{
		$this->flowerTypes[] = $flower;
	}

	protected function placeBlock(int $x, int $y, int $z, Block $block, ChunkManager $world, Random $random): void
	{
		$world->setBlockAt($x, $y, $z, $block);
		if ($block instanceof DoublePlant) {
			$world->setBlockAt($x, $y + 1, $z, (clone $block)->setTop(true));
		}
	}

	protected function canStay(int $x, int $y, int $z, ChunkManager $world): bool
	{
		return EnsureCover::ensureCover($x, $y, $z, $world) && EnsureGrassBelow::ensureGrassBelow($x, $y, $z, $world);
	}

	protected function getBlock(int $x, int $z, Random $random, ChunkManager $world): Block
	{
		return $this->flowerTypes[$random->nextRange(0, count($this->flowerTypes) - 1)] ?? VanillaBlocks::AIR();
	}

}
