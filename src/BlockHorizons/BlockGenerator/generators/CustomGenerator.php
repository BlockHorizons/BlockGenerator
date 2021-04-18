<?php

namespace BlockHorizons\BlockGenerator\generators;

use pocketmine\level\generator\Generator;
use pocketmine\utils\Random;

abstract class CustomGenerator extends Generator {

    public function __construct(array $options = [])
    {
        $this->settings = $options;
    }

    public function getSettings(): array
    {
        return $this->settings;
    }

}
