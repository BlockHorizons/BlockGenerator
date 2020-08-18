<?php
namespace BlockHorizons\BlockGenerator\object;

use BlockHorizons\BlockGenerator\math\FacingHelper;
use pocketmine\block\Block;

use pocketmine\level\ChunkManager;
use pocketmine\level\generator\object\Tree;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

class DarkOakTree extends CustomTree {

    public function __construct() {

    }

    /**
     * The metadata value of the wood to use in tree generation.
     */
    protected $metaWood = \pocketmine\block\Wood2::DARK_OAK;

    /**
     * The metadata value of the leaves to use in tree generation.
     */
    protected $metaLeaves = \pocketmine\block\Leaves::DARK_OAK;

    public function generate(ChunkManager $level, Random $rand, Vector3 $position) : bool {
        $i = $rand->nextBoundedInt(3) + $rand->nextBoundedInt(2) + 6;
        $j = $position->getFloorX();
        $k = $position->getFloorY();
        $l = $position->getFloorZ();

        if ($k >= 1 && $k + $i + 1 < 256) {
            $blockpos = $position->down();
            $block = $level->getBlockIdAt($blockpos->getFloorX(), $blockpos->getFloorY(), $blockpos->getFloorZ());

            if ($block !== Block::GRASS && $block !== Block::DIRT) {
                return false;
            } elseif (!$this->placeTreeOfHeight($level, $position, $i)) {
                return false;
            } else {
                $this->setDirtAt($level, $blockpos);
                $this->setDirtAt($level, $blockpos->east());
                $this->setDirtAt($level, $blockpos->south());
                $this->setDirtAt($level, $blockpos->south()->east());
                $face = Facing::HORIZONTAL[$rand->nextBoundedInt(3)];
                $i1 = $i - $rand->nextBoundedInt(4);
                $j1 = 2 - $rand->nextBoundedInt(3);
                $k1 = $j;
                $l1 = $l;
                $i2 = $k + $i - 1;

                for ($j2 = 0; $j2 < $i; ++$j2) {
                    if ($j2 >= $i1 && $j1 > 0) {
                        $k1 += FacingHelper::xOffset($face);
                        $l1 += FacingHelper::zOffset($face);
                        --$j1;
                    }

                    $k2 = $k + $j2;
                    $blockpos1 = new Vector3($k1, $k2, $l1);
                    $material = $level->getBlockIdAt($blockpos1->getFloorX(), $blockpos1->getFloorY(), $blockpos1->getFloorZ());

                    if ($material === Block::AIR || $material === Block::LEAVES) {
                        $this->placeLogAt($level, $blockpos1);
                        $this->placeLogAt($level, $blockpos1->east());
                        $this->placeLogAt($level, $blockpos1->south());
                        $this->placeLogAt($level, $blockpos1->east()->south());
                    }
                }

                for ($i3 = -2; $i3 <= 0; ++$i3) {
                    for ($l3 = -2; $l3 <= 0; ++$l3) {
                        $k4 = -1;
                        $this->placeLeafAt($level, $k1 + $i3, $i2 + $k4, $l1 + $l3);
                        $this->placeLeafAt($level, 1 + $k1 - $i3, $i2 + $k4, $l1 + $l3);
                        $this->placeLeafAt($level, $k1 + $i3, $i2 + $k4, 1 + $l1 - $l3);
                        $this->placeLeafAt($level, 1 + $k1 - $i3, $i2 + $k4, 1 + $l1 - $l3);

                        if (($i3 > -2 || $l3 > -1) && ($i3 != -1 || $l3 != -2)) {
                            $k4 = 1;
                            $this->placeLeafAt($level, $k1 + $i3, $i2 + $k4, $l1 + $l3);
                            $this->placeLeafAt($level, 1 + $k1 - $i3, $i2 + $k4, $l1 + $l3);
                            $this->placeLeafAt($level, $k1 + $i3, $i2 + $k4, 1 + $l1 - $l3);
                            $this->placeLeafAt($level, 1 + $k1 - $i3, $i2 + $k4, 1 + $l1 - $l3);
                        }
                    }
                }

                if ($rand->nextBoolean()) {
                    $this->placeLeafAt($level, $k1, $i2 + 2, $l1);
                    $this->placeLeafAt($level, $k1 + 1, $i2 + 2, $l1);
                    $this->placeLeafAt($level, $k1 + 1, $i2 + 2, $l1 + 1);
                    $this->placeLeafAt($level, $k1, $i2 + 2, $l1 + 1);
                }

                for ($j3 = -3; $j3 <= 4; ++$j3) {
                    for ($i4 = -3; $i4 <= 4; ++$i4) {
                        if (($j3 != -3 || $i4 != -3) && ($j3 != -3 || $i4 != 4) && ($j3 != 4 || $i4 != -3) && ($j3 != 4 || $i4 != 4) && (abs($j3) < 3 || abs($i4) < 3)) {
                            $this->placeLeafAt($level, $k1 + $j3, $i2, $l1 + $i4);
                        }
                    }
                }

                for ($k3 = -1; $k3 <= 2; ++$k3) {
                    for ($j4 = -1; $j4 <= 2; ++$j4) {
                        if (($k3 < 0 || $k3 > 1 || $j4 < 0 || $j4 > 1) && $rand->nextBoundedInt(3) <= 0) {
                            $l4 = $rand->nextBoundedInt(3) + 2;

                            for ($i5 = 0; $i5 < $l4; ++$i5) {
                                $this->placeLogAt($level, new Vector3($j + $k3, $i2 - $i5 - 1, $l + $j4));
                            }

                            for ($j5 = -1; $j5 <= 1; ++$j5) {
                                for ($l2 = -1; $l2 <= 1; ++$l2) {
                                    $this->placeLeafAt($level, $k1 + $k3 + $j5, $i2, $l1 + $j4 + $l2);
                                }
                            }

                            for ($k5 = -2; $k5 <= 2; ++$k5) {
                                for ($l5 = -2; $l5 <= 2; ++$l5) {
                                    if (abs($k5) != 2 || abs($l5) != 2) {
                                        $this->placeLeafAt($level, $k1 + $k3 + $k5, $i2 - 1, $l1 + $j4 + $l5);
                                    }
                                }
                            }
                        }
                    }
                }

                return true;
            }
        } else {
            return false;
        }
    }

    protected function placeTreeOfHeight(ChunkManager $worldIn, Vector3 $pos, int $height) : bool {
        $i = $pos->getFloorX();
        $j = $pos->getFloorY();
        $k = $pos->getFloorZ();
        $p2 = new Vector3();

        for ($l = 0; $l <= $height + 1; ++$l) {
            $i1 = 1;

            if ($l === 0) {
                $i1 = 0;
            }

            if ($l >= $height - 1) {
                $i1 = 2;
            }

            for ($j1 = -$i1; $j1 <= $i1; ++$j1) {
                for ($k1 = -$i1; $k1 <= $i1; ++$k1) {
                    $p2->setComponents($i + $j1, $j + $l, $k + $k1);
                    if (!$this->canOverride(Block::get($worldIn->getBlockIdAt($p2->getX(), $p2->getY(), $p2->getZ())))) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    protected function placeLogAt(ChunkManager $worldIn, Vector3 $pos) : void {
        if ($this->canOverride(Block::get($worldIn->getBlockIdAt($pos->getX(), $pos->getY(), $pos->getZ())))) {
            $this->setBlockAndNotifyAdequately($worldIn, $pos, Block::get(Block::LOG2, \pocketmine\block\Wood2::DARK_OAK));
        }
    }

    protected function placeLeafAt(ChunkManager $worldIn, int $x, int $y, int $z) : void {
        $material = $worldIn->getBlockIdAt($x, $y, $z);

        if ($material === Block::AIR) {
            $this->setBlockAndNotifyAdequately($worldIn, new Vector3($x, $y, $z), Block::get(Block::LEAVES2, $this->metaLeaves));
        }
    }

    public function setBlockAndNotifyAdequately(ChunkManager $level, Vector3 $pos, Block $block) : void {
        $level->setBlockIdAt($pos->x, $pos->y, $pos->z, $block->getId());
        $level->setBlockDataAt($pos->x, $pos->y, $pos->z, $block->getDamage());
    }

    public function setDirtAt(ChunkManager $level, Vector3 $pos) : void {
        $level->setBlockIdAt($pos->x, $pos->y, $pos->z, Block::DIRT);
    }

}
