<?php

namespace BlockHorizons\BlockGenerator\biomes\impl\extremehills;

use BlockHorizons\BlockGenerator\math\CustomRandom;
use BlockHorizons\BlockGenerator\noise\SimplexF;
use pocketmine\block\Block;

class ExtremeHillsMBiome extends ExtremeHillsPlusBiome
{

    private static $gravelNoise;

    private $isGravel = false;

    public function __construct(bool $tree = true)
    {
        parent::__construct($tree);

        if (!self::$gravelNoise) self::$gravelNoise = new SimplexF(new CustomRandom(0), 1.0, 1 / 4.0, 1 / 64);

        $this->setBaseHeight(1);
        $this->setHeightVariation(0.5);
    }

    public function getName(): string
    {
        return "Extreme Hills M";
    }

    public function getSurfaceBlock(int $y): int
    {
        return $this->isGravel ? Block::GRAVEL : parent::getSurfaceBlock($y);
    }

    public function getSurfaceDepth(int $y): int
    {
        return $this->isGravel ? 4 : parent::getSurfaceDepth($y);
    }

    public function getGroundDepth(int $y): int
    {
        return $this->isGravel ? 0 : parent::getGroundDepth($y);
    }

    public function preCover(int $x, int $z)
    {
        //-0.75 is farily rare, so there'll be much more gravel than grass
        $this->isGravel = self::$gravelNoise->noise2D($x, $z, true) < -0.75;
    }

    public function doesOverhang(): bool
    {
        return false;
    }
}
