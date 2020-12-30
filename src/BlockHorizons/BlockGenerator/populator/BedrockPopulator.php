<?php

namespace BlockHorizons\BlockGenerator\populator;

use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\level\generator\populator\Populator;
use pocketmine\utils\Random;

class BedrockPopulator extends Populator
{

    /**
     * @param ChunkManager $level
     * @param int $chunkX
     * @param int $chunkZ
     * @param Random $random
     */
    public function populate(ChunkManager $level, int $chunkX, int $chunkZ, Random $random): void
    {
        $chunk = $level->getChunk($chunkX, $chunkZ);
        for ($x = 0; $x < 16; $x++) {
            for ($z = 0; $z < 16; $z++) {
                $chunk->setBlockId($x, 0, $z, Block::BEDROCK);
                for ($i = 1; $i < 5; $i++) {
                    if ($random->nextBoundedInt($i) == 0) { //decreasing amount
                        $chunk->setBlockId($x, $i, $z, Block::BEDROCK);
                    }
                }
            }
        }
    }

}