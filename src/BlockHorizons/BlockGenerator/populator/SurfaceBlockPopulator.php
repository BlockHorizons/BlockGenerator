<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\populator\helper\PopulatorHelpers;
use pocketmine\block\Block;
use pocketmine\utils\Random;
use pocketmine\world\ChunkManager;
use pocketmine\world\format\Chunk;

abstract class SurfaceBlockPopulator extends PopulatorCount
{

	protected function populateCount(ChunkManager $world, int $chunkX, int $chunkZ, Random $random): void
	{
		$realX = $random->nextBoundedInt(16) + $chunkX * Chunk::EDGE_LENGTH;
		$realZ = $random->nextBoundedInt(16) + $chunkZ * Chunk::EDGE_LENGTH;

		$y = $this->getHighestWorkableBlock($world, $realX, $realZ, $world);
		if ($y > 0 && $this->canStay($realX, $y, $realZ, $world)) {
			$this->placeBlock($realX, $y, $realZ, $this->getBlock($realX, $realZ, $random, $world), $world, $random);
		}
	}

	protected function getHighestWorkableBlock(ChunkManager $world, int $x, int $z): int
	{
		$y = 0;
		//start at 254 because we add one afterwards
		for ($y = 254; $y >= 0; --$y) {
			if (!PopulatorHelpers::isNonSolid($world->getBlockAt($x, $y, $z)->getId())) {
				break;
			}
		}

		return $y === 0 ? -1 : ++$y;
	}

	protected abstract function canStay(int $x, int $y, int $z, ChunkManager $world): bool;

	protected function placeBlock(int $x, int $y, int $z, Block $block, ChunkManager $world, Random $random): void
	{
		$world->setBlockAt($x, $y, $z, $block);
	}

	protected abstract function getBlock(int $x, int $z, Random $random, ChunkManager $world): Block;

}