<?php

namespace BlockHorizons\BlockGenerator\object;

use pocketmine\level\generator\object\Tree;
use pocketmine\block\Block;

abstract class CustomTree extends Tree {

	public function canOverride(Block $block) : bool {
		return isset($this->overridable[$block->getId()]);
	}

}