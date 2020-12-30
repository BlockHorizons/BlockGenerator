<?php

namespace BlockHorizons\BlockGenerator\biomes\impl\extremehills;

use BlockHorizons\BlockGenerator\biomes\type\SnowyBiome;
use BlockHorizons\BlockGenerator\math\CustomRandom;
use BlockHorizons\BlockGenerator\populator\TreePopulator;
use pocketmine\block\Block;
use pocketmine\level\generator\noise\Simplex;

class ExtremeHillsBiome extends SnowyBiome
{

    public function __construct(bool $tree = true)
    {
        parent::__construct();

        if ($tree) {
            $trees = new TreePopulator(\pocketmine\block\Wood::SPRUCE);
            $trees->setBaseAmount(2);
            $trees->setRandomAmount(2);
            $this->addPopulator($trees);
        }

        $this->setBaseHeight(1);
        $this->setHeightVariation(0.5);

        $this->snowNoise = new Simplex(new CustomRandom(1337), 8, 100.0 / 8.0, 1.0 / 9000);

        $this->x = 0;
        $this->z = 0;
    }

    public function getCoverBlock(int $y): int
    {
        $this->x++;
        $this->z++;
        if ($y > 92) {
            if ($y > 102) return parent::getCoverBlock($y);
            $v = $this->snowNoise->noise2D($this->x, $this->z, true);
            if ($this->snowNoise->noise2D($this->x, $this->z) > 0) {
                return parent::getCoverBlock($y);
            }
        }
        return Block::AIR;
    }

    public function getName(): string
    {
        return "Extreme Hills";
    }

    public function doesOverhang(): bool
    {
        return true;
    }

}
