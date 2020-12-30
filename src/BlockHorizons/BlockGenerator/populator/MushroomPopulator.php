<?php
namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\object\mushroom\BigMushroom;
use BlockHorizons\BlockGenerator\populator\PopulatorCount;
use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\level\format\Chunk;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

class MushroomPopulator extends PopulatorCount {
    
    private $type;

    public function __construct(int $type = null) {
        $this->type = $type === null ? mt_rand(0, 1) : $type;
    }

    public function populateCount(ChunkManager $level, int $chunkX, int $chunkZ, Random $random) : void {
        $x = ($chunkX << 4) | $random->nextBoundedInt(16);
        $z = ($chunkZ << 4) | $random->nextBoundedInt(16);
        $y = $this->getHighestWorkableBlock($level, $x, $z, $level->getChunk($chunkX, $chunkZ));
        if ($y !== -1) {
            (new BigMushroom($this->type))->generate($level, $random, new Vector3($x, $y, $z));
        }
    }

    protected function getHighestWorkableBlock(ChunkManager $level, int $x, int $z, Chunk $chunk) : int {
        $y = 0;
        $x &= 0xF;
        $z &= 0xF;
        for ($y = 254; $y > 0; --$y) {
            $b = $chunk->getBlockId($x, $y, $z);
            if ($b === Block::DIRT || $b === Block::GRASS || $b === Block::MYCELIUM) {
                break;
            } elseif ($b !== Block::AIR && $b !== Block::SNOW_LAYER) {
                return -1;
            }
        }

        return ++$y;
    }

}