<?php
namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\populator\helper\EnsureBelow;
use BlockHorizons\BlockGenerator\populator\helper\EnsureCover;
use BlockHorizons\BlockGenerator\populator\helper\EnsureGrassBelow;
use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\level\Level;
use pocketmine\level\format\Chunk;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

class SugarcanePopulator extends SurfaceBlockPopulator {
	
	private function findWater(int $x, int $y, int $z, Chunk $chunk) : bool {
        $count = 0;
        for ($i = $x - 4; $i < ($x + 4); $i++) {
            for ($j = $z - 4; $j < ($z + 4); $j++) {
                if(!$i || !$j || $i > 15 || $j > 15) continue; // edge of chunk
                $b = $chunk->getBlockId($i, $y, $j);
                if ($b === Block::WATER || $b === Block::STILL_WATER) {
                    $count++;
                }
                if ($count > 10) {
                    return true;
                }
            }
        }
        return ($count > 10);
    }

    protected function spread(int $x, int $y, int $z, ChunkManager $level) : ? Vector3 {
        $i = 0;
        $j = 0;
        $chunk = $level->getChunk($x >> 4, $z >> 4);

        for($i = -1; $i <= 1; $i++) {
            for($j = -1; $j <= 1; $j++) {
                $y = $this->getHighestWorkableBlock($x, $z, $chunk);
                if($y < 0) break;

                $id = $level->getBlockIdAt($x + $i, $y, $z + $j);
                if($id === Block::SAND) break;

            }
        }
        if($y < 0) return null;

        return new Vector3($x + $i, $y, $z + $j);
    }

    protected function canStay(int $x, int $y, int $z, Chunk $chunk) : bool {
        return EnsureCover::ensureCover($x, $y, $z, $chunk) && (EnsureGrassBelow::ensureGrassBelow($x, $y, $z, $chunk) || EnsureBelow::ensureBelow($x, $y, $z, Block::SAND, $chunk)) && $this->findWater($x, $y - 1, $z, $chunk);
    }

    protected function getBlockId(int $x, int $z, Random $random, Chunk $chunk) : int {
        return Block::SUGARCANE_BLOCK;
    }

}