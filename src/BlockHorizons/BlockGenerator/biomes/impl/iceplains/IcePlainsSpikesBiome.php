<?php

namespace BlockHorizons\BlockGenerator\biomes\impl\iceplains;

use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\level\format\Chunk;
use pocketmine\level\generator\populator\Populator;
use pocketmine\utils\Random;

class IcePlainsSpikesBiome extends IcePlainsBiome
{

    public function __construct()
    {
        parent::__construct();

        $iceSpikes = new IceSpikesPopulator();
        $this->addPopulator($iceSpikes);
    }

    public function getSurfaceBlock(int $y): int
    {
        return Block::SNOW_BLOCK;
    }

    public function getName(): string
    {
        return "Ice Plains Spikes";
    }

    public function isFreezing(): bool
    {
        return true;
    }

}


class IceSpikesPopulator extends Populator
{

    public function populate(ChunkManager $level, int $chunkX, int $chunkZ, Random $random): void
    {
        for ($i = 0; $i < 8; $i++) {
            $x = ($chunkX << 4) + $random->nextBoundedInt(16);
            $z = ($chunkZ << 4) + $random->nextBoundedInt(16);
            $chunk = $level->getChunk($x >> 4, $z >> 4);
            $isTall = $random->nextBoundedInt(16) == 0;
            $height = 10 + $random->nextBoundedInt(16) + ($isTall ? $random->nextBoundedInt(31) : 0);
            $startY = $this->getHighestWorkableBlock($x, $z, $chunk);
            $maxY = $startY + $height;
            if ($isTall) {
                for ($y = $startY; $y < $maxY; $y++) {
                    //center column
                    $level->setBlockIdAt($x, $y, $z, Block::PACKED_ICE);
                    //t shape
                    $level->setBlockIdAt($x + 1, $y, $z, Block::PACKED_ICE);
                    $level->setBlockIdAt($x - 1, $y, $z, Block::PACKED_ICE);
                    $level->setBlockIdAt($x, $y, $z + 1, Block::PACKED_ICE);
                    $level->setBlockIdAt($x, $y, $z - 1, Block::PACKED_ICE);
                    //additional blocks on the side
                    if ($random->nextBoolean()) {
                        $level->setBlockIdAt($x + 1, $y, $z + 1, Block::PACKED_ICE);
                    }
                    if ($random->nextBoolean()) {
                        $level->setBlockIdAt($x + 1, $y, $z - 1, Block::PACKED_ICE);
                    }
                    if ($random->nextBoolean()) {
                        $level->setBlockIdAt($x - 1, $y, $z + 1, Block::PACKED_ICE);
                    }
                    if ($random->nextBoolean()) {
                        $level->setBlockIdAt($x - 1, $y, $z - 1, Block::PACKED_ICE);
                    }
                }
                //finish with a point
                $level->setBlockIdAt($x + 1, $maxY, $z, Block::PACKED_ICE);
                $level->setBlockIdAt($x - 1, $maxY, $z, Block::PACKED_ICE);
                $level->setBlockIdAt($x, $maxY, $z + 1, Block::PACKED_ICE);
                $level->setBlockIdAt($x, $maxY, $z - 1, Block::PACKED_ICE);
                for ($y = $maxY; $y < $maxY + 3; $maxY++) {
                    $level->setBlockIdAt($x, $y, $z, Block::PACKED_ICE);
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
                            if ((int)$currWidth != (int)$currDist && $random->nextBoolean()) {
                                $level->setBlockIdAt($x + $xx, $y, $z + $zz, Block::PACKED_ICE);
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
