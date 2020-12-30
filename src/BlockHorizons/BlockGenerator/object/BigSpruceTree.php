<?php

namespace BlockHorizons\BlockGenerator\object;

use BlockHorizons\BlockGenerator\populator\helper\PopulatorHelpers;
use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\level\generator\object\SpruceTree;
use pocketmine\utils\Random;

class BigSpruceTree extends SpruceTree
{

    /** @var int */
    private $leafStartHeightMultiplier;
    private $baseLeafRadius;

    public function __construct(float $leafStartHeightMultiplier, int $baseLeafRadius)
    {
        parent::__construct();

        $this->leafStartHeightMultiplier = $leafStartHeightMultiplier;
        $this->baseLeafRadius = $baseLeafRadius;
    }

    public function placeObject(ChunkManager $level, int $x, int $y, int $z, Random $random): void
    {
        $this->treeHeight = $random->nextBoundedInt(15) + 20;

        $topSize = $this->treeHeight - (int)($this->treeHeight * $this->leafStartHeightMultiplier);
        $lRadius = $this->baseLeafRadius + $random->nextBoundedInt(2);

        $this->placeTrunk($level, $x, $y, $z, $random, $this->treeHeight - $random->nextBoundedInt(3));

        $this->placeLeaves($level, $topSize, $lRadius, $x, $y, $z, $random);
    }

    protected function placeTrunk(ChunkManager $level, int $x, int $y, int $z, Random $random, int $trunkHeight): void
    {
        // The base dirt block
        $level->setBlockIdAt($x, $y - 1, $z, Block::DIRT);
        $radius = 2;

        for ($yy = 0; $yy < $trunkHeight; ++$yy) {
            for ($xx = 0; $xx < $radius; $xx++) {
                for ($zz = 0; $zz < $radius; $zz++) {
                    $block = $level->getBlockIdAt($x, $y + $yy, $z);
                    if ($this->canOverride(Block::get($block))) {
                        $level->setBlockIdAt($x + $xx, $y + $yy, $z + $zz, $this->trunkBlock);
                        $level->setBlockDataAt($x + $xx, $y + $yy, $z + $zz, $this->type);
                    }
                }
            }
        }
    }

    public function canOverride(Block $block): bool
    {
        return isset($this->overridable[$block->getId()]);
    }

    public function placeLeaves(ChunkManager $level, int $topSize, int $lRadius, int $x, int $y, int $z, Random $random): void
    {
        $radius = $random->nextBoundedInt(2);
        $maxR = 1;
        $minR = 0;

        for ($yy = 0; $yy <= $topSize; ++$yy) {
            $yyy = $y + $this->treeHeight - $yy;

            for ($xx = $x - $radius; $xx <= $x + $radius; ++$xx) {
                $xOff = abs($xx - $x);
                for ($zz = $z - $radius; $zz <= $z + $radius; ++$zz) {
                    $zOff = abs($zz - $z);
                    if ($xOff === $radius && $zOff === $radius && $radius > 0) {
                        continue;
                    }

                    if (PopulatorHelpers::isNonSolid($level->getBlockIdAt($xx, $yyy, $zz))) {
                        $level->setBlockIdAt($xx, $yyy, $zz, $this->leafBlock);
                        $level->setBlockDataAt($xx, $yyy, $zz, $this->type);
                    }
                }
            }

            if ($radius >= $maxR) {
                $radius = $minR;
                $minR = 1;
                if (++$maxR > $lRadius) {
                    $maxR = $lRadius;
                }
            } else {
                ++$radius;
            }
        }
    }


}
