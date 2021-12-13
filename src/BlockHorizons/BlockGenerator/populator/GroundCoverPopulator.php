<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\biomes\CustomBiome;
use BlockHorizons\BlockGenerator\biomes\type\CoveredBiome;
use pocketmine\block\VanillaBlocks;
use pocketmine\utils\Random;
use pocketmine\world\ChunkManager;
use pocketmine\world\format\Chunk;
use pocketmine\world\generator\populator\Populator;


class GroundCoverPopulator implements Populator
{

	public function populate(ChunkManager $world, int $chunkX, int $chunkZ, Random $random): void
	{
		$baseX = $chunkX * Chunk::EDGE_LENGTH;
		$baseZ = $chunkZ * Chunk::EDGE_LENGTH;
		$chunk = $world->getChunk($chunkX, $chunkZ);

		for ($x = 0; $x < 16; ++$x) {
			for ($z = 0; $z < 16; ++$z) {
				$y = 254;

				$biome = CustomBiome::getBiome($chunk->getBiomeId($x, $z));
				$realX = $baseX + $x;
				$realZ = $baseZ + $z;

				if ($biome instanceof CoveredBiome === false) {
					continue;
				}
				$biome->preCover($baseX | $x, $baseZ | $z);

				while (($y = $this->getNextStone($chunk, $x, $y, $z)) >= 0) {

					if (($coverBlock = $biome->getCoverBlock($y))->getId() > 0) {
						$world->setBlockAt($realX, $y + 1, $realZ, $coverBlock);
					}
					$maxSurfaceDepth = max(min(
						$stoneDepth = $y - ($this->getNextAir($chunk, $x, $y, $z) - 1),
						$biome->getSurfaceDepth($y)
					), 0);

					for ($i = 0; $i < $maxSurfaceDepth; $i++) {
						$world->setBlockAt($realX, $realY = $y - $i, $realZ, $biome->getSurfaceBlock($realY));
					}
					$y -= $maxSurfaceDepth;

					$remainingStones = $stoneDepth - $maxSurfaceDepth;
					if ($remainingStones === 0) {
						continue;
					}

					$maxGroundDepth = max(min(
						$remainingStones,
						$biome->getGroundDepth($y)
					), 0);
					for ($i = 0; $i < $maxGroundDepth; $i++) {
						$world->setBlockAt($realX, $realY = $y - $i, $realZ, $biome->getGroundBlock($realY));
					}

					$y = $this->getNextAir($chunk, $x, $y - $maxGroundDepth, $z);
				}
			}
		}
	}

	private function getNextStone(Chunk $chunk, int $x, int $y, int $z): int
	{
		for (; $y >= 0 && $chunk->getFullBlock($x, $y, $z) !== VanillaBlocks::STONE()->getFullId(); $y--) {
			//
		}
		return $y;
	}

	private function getNextAir(Chunk $chunk, int $x, int $y, int $z): int
	{
		for (; $y >= 0 && $chunk->getFullBlock($x, $y, $z) !== VanillaBlocks::AIR()->getFullId(); $y--) {
			//
		}
		return $y;
	}

}
