<?php

namespace BlockHorizons\BlockGenerator\object;

use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

abstract class BasicGenerator
{

    //also autism, see below
    public abstract function generate(ChunkManager $level, Random $rand, Vector3 $position): bool;

    public function setDecorationDefaults(): void
    {
    }

    protected function setBlockAndNotifyAdequately(ChunkManager $level, Vector3 $pos, Block $state): void
    {
        $this->setBlock($level, $pos, $state);
    }

    //what autism is this? why are we using floating-point vectors for setting block IDs?
    protected function setBlock(ChunkManager $level, Vector3 $v, Block $b): void
    {
        $level->setBlockIdAt((int)$v->x, (int)$v->y, (int)$v->z, $b->getId());
        $level->setBlockDataAt((int)$v->x, (int)$v->y, (int)$v->z, $b->getVariant());
    }
}
