<?php
namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\biomes\CustomBiome;
use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\level\generator\populator\Populator;
use pocketmine\utils\Random;

class WaterIcePopulator extends Populator {

	public function populate(ChunkManager $level, int $chunkX, int $chunkZ, Random $random) : void {
		$chunk = $level->getChunk($chunkX, $chunkZ);
        for ($x = 0; $x < 16; $x++) {
            for ($z = 0; $z < 16; $z++) {
                $biome = CustomBiome::getBiome($chunk->getBiomeId($x, $z));
                if ($biome->isFreezing()) {
                    $topBlock = $chunk->getHighestBlockAt($x, $z);
                    if ($chunk->getBlockId($x, $topBlock, $z) == Block::STILL_WATER)     {
                        $chunk->setBlockId($x, $topBlock, $z, Block::ICE);
                    }
                }
            }
        }
    }

}