<?php

namespace BlockHorizons\BlockGenerator\populator\tree;

use BlockHorizons\BlockGenerator\object\SwampTree;
use BlockHorizons\BlockGenerator\populator\PopulatorCount;
use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

class SwampTreePopulator extends PopulatorCount
{

    private $level;

    private $type;

    public function __construct(int $type = \pocketmine\block\Wood::OAK)
    {
        $this->type = $type;
    }

    public function populateCount(ChunkManager $level, int $chunkX, int $chunkZ, Random $random): void
    {
        $this->level = $level;

        $x = $random->nextRange($chunkX << 4, ($chunkX << 4) + 15);
        $z = $random->nextRange($chunkZ << 4, ($chunkZ << 4) + 15);
        $y = $this->getHighestWorkableBlock($x, $z);
        if ($y === -1) {
            return;
        }
        (new SwampTree($this->type))->generate($level, $random, new Vector3($x, $y, $z));
    }

    private function getHighestWorkableBlock(int $x, int $z): int
    {
        $y;
        for ($y = 127; $y > 0; --$y) {
            $b = $this->level->getBlockIdAt($x, $y, $z);
            if ($b === Block::DIRT || $b === Block::GRASS || $b === Block::TALL_GRASS) {
                break;
            } elseif ($b !== Block::AIR && $b !== Block::SNOW_LAYER) {
                return -1;
            }
        }

        return ++$y;
    }

}
