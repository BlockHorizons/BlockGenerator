<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\populator;

use pocketmine\block\PackedIce;
use pocketmine\block\VanillaBlocks;
use pocketmine\utils\Random;
use pocketmine\world\ChunkManager;
use pocketmine\world\format\Chunk;
use pocketmine\world\generator\populator\Populator;

class IceSpikesPopulator implements Populator
{

	protected PackedIce $packedIce;

	public function __construct() {
		$this->packedIce = VanillaBlocks::PACKED_ICE();
	}

	public function populate(ChunkManager $world, int $chunkX, int $chunkZ, Random $random): void
	{
		for ($i = 0; $i < 8; $i++) {
			$x = ($chunkX * Chunk::EDGE_LENGTH) + $random->nextBoundedInt(16);
			$z = ($chunkZ * Chunk::EDGE_LENGTH) + $random->nextBoundedInt(16);

			$chunk = $world->getChunk($chunkX, $chunkZ);

			$isTall = $random->nextBoundedInt(16) == 0;
			$height = 10 + $random->nextBoundedInt(16) + ($isTall ? $random->nextBoundedInt(31) : 0);

			$startY = $this->getHighestWorkableBlock($x, $z, $chunk);
			$maxY = $startY + $height;

			if ($isTall) {
				for ($y = $startY; $y < $maxY; $y++) {
					//center column
					$world->setBlockAt($x, $y, $z, $this->packedIce);
					//t shape
					$world->setBlockAt($x + 1, $y, $z, $this->packedIce);
					$world->setBlockAt($x - 1, $y, $z, $this->packedIce);
					$world->setBlockAt($x, $y, $z + 1, $this->packedIce);
					$world->setBlockAt($x, $y, $z - 1, $this->packedIce);
					//additional blocks on the side
					if ($random->nextBoolean()) {
						$world->setBlockAt($x + 1, $y, $z + 1, $this->packedIce);
					}
					if ($random->nextBoolean()) {
						$world->setBlockAt($x + 1, $y, $z - 1, $this->packedIce);
					}
					if ($random->nextBoolean()) {
						$world->setBlockAt($x - 1, $y, $z + 1, $this->packedIce);
					}
					if ($random->nextBoolean()) {
						$world->setBlockAt($x - 1, $y, $z - 1, $this->packedIce);
					}
				}
				//finish with a point
				$world->setBlockAt($x + 1, $maxY, $z, $this->packedIce);
				$world->setBlockAt($x - 1, $maxY, $z, $this->packedIce);
				$world->setBlockAt($x, $maxY, $z + 1, $this->packedIce);
				$world->setBlockAt($x, $maxY, $z - 1, $this->packedIce);
				for ($y = $maxY; $y < $maxY + 3; $maxY++) {
					$world->setBlockAt($x, $y, $z, $this->packedIce);
				}
			} else {
				//the maximum possible radius in blocks
				$baseWidth = $random->nextBoundedInt(1) + 4;
				$shrinkFactor = $baseWidth / $height;
				$currWidth = $baseWidth;
				for ($y = $startY; $y < $maxY; $y++) {
					for ($xx = (int)-$currWidth; $xx < $currWidth; $xx++) {
						for ($zz = (int)-$currWidth; $zz < $currWidth; $zz++) {
							$currDist = (int)sqrt($xx * $xx + $zz * $zz);
							if ((int)$currWidth != $currDist && $random->nextBoolean()) {
								$world->setBlockAt($x + $xx, $y, $z + $zz, $this->packedIce);
							}
						}
					}
					$currWidth -= $shrinkFactor;
				}
			}
		}
	}

	public function getHighestWorkableBlock(int $x, int $z, Chunk $chunk): int
	{
		return $chunk->getHighestBlockAt($x & 0xF, $z & 0xF) - 5;
	}

}
