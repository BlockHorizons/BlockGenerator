<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\biomes\CustomBiome;
use pocketmine\block\BlockLegacyIds;
use pocketmine\block\VanillaBlocks;
use pocketmine\utils\Random;
use pocketmine\world\ChunkManager;
use pocketmine\world\format\Chunk;
use pocketmine\world\generator\populator\Populator;

class WaterIcePopulator implements Populator
{

	public function populate(ChunkManager $world, int $chunkX, int $chunkZ, Random $random): void
	{
		$chunk = $world->getChunk($chunkX, $chunkZ);
		$baseX = $chunkX * Chunk::EDGE_LENGTH;
		$baseZ = $chunkZ * Chunk::EDGE_LENGTH;
		for ($x = 0; $x < 16; $x++) {
			for ($z = 0; $z < 16; $z++) {
				$biome = CustomBiome::getBiome($chunk->getBiomeId($x, $z));
				if ($biome->isFreezing()) {
					$y = $chunk->getHighestBlockAt($x, $z);
					if ($world->getBlockAt($baseX + $x, $y, $baseZ + $z)->getId() == BlockLegacyIds::STILL_WATER) {
						$world->setBlockAt($baseX + $x, $y, $baseZ + $z, VanillaBlocks::ICE());
					}
				}
			}
		}
	}

}