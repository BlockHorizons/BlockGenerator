<?php

namespace BlockHorizons\BlockGenerator\object;

use pocketmine\block\Block;
use pocketmine\level\generator\object\Tree;

abstract class CustomTree extends Tree
{

    public function canOverride(Block $block): bool
    {
        return isset($this->overridable[$block->getId()]);
    }

}