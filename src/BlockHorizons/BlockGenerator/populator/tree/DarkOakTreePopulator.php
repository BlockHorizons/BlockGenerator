<?php
namespace BlockHorizons\BlockGenerator\populator\tree;

use BlockHorizons\BlockGenerator\object\DarkOakTree;
use BlockHorizons\BlockGenerator\populator\PopulatorCount;
use pocketmine\block\Block;

use pocketmine\level\ChunkManager;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

class DarkOakTreePopulator extends PopulatorCount {
    
    protected $level;

    protected $type;

    public function __construct(int $type = \pocketmine\block\Wood2::DARK_OAK) {
        $this->type = $type;
    }

    public function populateCount(ChunkManager $level, int $chunkX, int $chunkZ, Random $random) : void {
        $this->level = $level;

        $x = $random->nextRange($chunkX << 4, ($chunkX << 4) + 15);
        $z = $random->nextRange($chunkZ << 4, ($chunkZ << 4) + 15);
        $y = $this->getHighestWorkableBlock($x, $z);
        if ($y === -1) {
            return;
        }

        (new DarkOakTree())->generate($level, $random, new Vector3($x, $y, $z));
    }

    protected function getHighestWorkableBlock(int $x, int $z) : int {
        $y = 0;
        for ($y = 255; $y > 0; --$y) {
            $b = $this->level->getBlockIdAt($x, $y, $z);
            if ($b === Block::DIRT || $b === Block::GRASS) {
                break;
            } elseif ($b !== Block::AIR && $b !== Block::SNOW_LAYER) {
                return -1;
            }
        }

        return ++$y;
    }
}
