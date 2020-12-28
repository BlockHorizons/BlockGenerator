<?php

namespace BlockHorizons\BlockGenerator\object;

use BlockHorizons\BlockGenerator\math\FacingHelper;
use pocketmine\block\Block;
use pocketmine\block\Wood2;
use pocketmine\level\ChunkManager;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

class AcaciaTree extends CustomTree
{

    public $trunkBlock = Block::WOOD2;
    public $leafBlock = Block::LEAVES2;
    public $blockMeta = Wood2::ACACIA;

    public function placeObject(ChunkManager $level, int $x, int $y, int $z, Random $rand): void
    {
        $i = $rand->nextBoundedInt(3) + $rand->nextBoundedInt(3) + 5;
        $flag = true;

        if ($y >= 1 && $y + $i + 1 <= 256) {
            for ($j = $y; $j <= $y + 1 + $i; ++$j) {
                $k = 1;

                if ($j === $y) {
                    $k = 0;
                }

                if ($j >= $y + 1 + $i - 2) {
                    $k = 2;
                }

                $vector3 = new Vector3();

                for ($l = (int)$x - $k; $l <= $x + $k && $flag; ++$l) {
                    for ($i1 = (int)$z - $k; $i1 <= $z + $k && $flag; ++$i1) {
                        if ($j >= 0 && $j < 256) {

                            $vector3->setComponents($l, $j, $i1);
                            if (!$this->canOverride(Block::get($level->getBlockAt((int)$vector3->x, (int)$vector3->y, (int)$vector3->z)->getId()))) {
                                $flag = false;
                            }
                        } else {
                            $flag = false;
                        }
                    }
                }
            }

            if (!$flag) {
                return;
            } else {
                $block = $level->getBlockAt($x, $y - 1, $z)->getId();

                if (($block === Block::GRASS || $block === Block::DIRT) && $y < 256 - $i - 1) {

                    $level->setBlockIdAt($x, $y - 1, $z, Block::DIRT);

                    $face = FacingHelper::HORIZONTAL[$rand->nextBoundedInt(4)];
                    $k2 = $i - $rand->nextBoundedInt(4) - 1;
                    $l2 = 3 - $rand->nextBoundedInt(3);
                    $i3 = $x;
                    $j1 = $z;
                    $k1 = 0;

                    for ($l1 = 0; $l1 < $i; ++$l1) {
                        $i2 = $y + $l1;

                        if ($l1 >= $k2 && $l2 > 0) {
                            $i3 += FacingHelper::xOffset($face);
                            $j1 += FacingHelper::zOffset($face); // z;
                            $i3 += mt_rand(-1, 1);
                            $j1 += mt_rand(-1, 1);
                            --$l2;
                        }

                        $blockpos = new Vector3($i3, $i2, $j1);
                        $material = $level->getBlockAt($blockpos->getFloorX(), $blockpos->getFloorY(), $blockpos->getFloorZ())->getId();

                        if ($material === Block::AIR || $material === Block::LEAVES) {
                            $this->placeLogAt($level, $blockpos);
                            $k1 = $i2;
                        }
                    }

                    $blockpos2 = new Vector3($i3, $k1, $j1);

                    for ($j3 = -3; $j3 <= 3; ++$j3) {
                        for ($i4 = -3; $i4 <= 3; ++$i4) {
                            if (abs($j3) !== 3 || abs($i4) !== 3) {
                                $this->placeLeafAt($level, $blockpos2->add($j3, 0, $i4));
                            }
                        }
                    }

                    $blockpos2 = $blockpos2->up();

                    for ($k3 = -1; $k3 <= 1; ++$k3) {
                        for ($j4 = -1; $j4 <= 1; ++$j4) {
                            $this->placeLeafAt($level, $blockpos2->add($k3, 0, $j4));
                        }
                    }

                    $this->placeLeafAt($level, $blockpos2->east(2));
                    $this->placeLeafAt($level, $blockpos2->west(2));
                    $this->placeLeafAt($level, $blockpos2->south(2));
                    $this->placeLeafAt($level, $blockpos2->north(2));
                    $i3 = $x;
                    $j1 = $z;
                    $face1 = FacingHelper::HORIZONTAL[$rand->nextBoundedInt(4)];

                    if ($face1 != $face) {
                        $l3 = $k2 - $rand->nextBoundedInt(2) - 1;
                        $k4 = 1 + $rand->nextBoundedInt(3);
                        $k1 = 0;

                        for ($l4 = $l3; $l4 < $i && $k4 > 0; --$k4) {
                            if ($l4 >= 1) {
                                $j2 = $y + $l4;
                                $i3 += FacingHelper::xOffset($face);
                                $j1 += FacingHelper::zOffset($face);
                                $blockpos1 = new Vector3($i3, $j2, $j1);
                                $material1 = $level->getBlockAt($blockpos1->getFloorX(), $blockpos1->getFloorY(), $blockpos1->getFloorZ());

                                if ($material1 === Block::AIR || $material1 === Block::LEAVES) {
                                    $this->placeLogAt($level, $blockpos1);
                                    $k1 = $j2;
                                }
                            }

                            ++$l4;
                        }

                        if ($k1 > 0) {
                            $blockpos3 = new Vector3($i3, $k1, $j1);

                            for ($i5 = -2; $i5 <= 2; ++$i5) {
                                for ($k5 = -2; $k5 <= 2; ++$k5) {
                                    if (abs($i5) != 2 || abs($k5) != 2) {
                                        $this->placeLeafAt($level, $blockpos3->add($i5, 0, $k5));
                                    }
                                }
                            }

                            $blockpos3 = $blockpos3->up();

                            for ($j5 = -1; $j5 <= 1; ++$j5) {
                                for ($l5 = -1; $l5 <= 1; ++$l5) {
                                    $this->placeLeafAt($level, $blockpos3->add($j5, 0, $l5));
                                }
                            }
                        }
                    }

                    return;
                } else {
                    return;
                }
            }
        }
    }

    private function placeLogAt(ChunkManager $level, Vector3 $pos): void
    {
        $level->setBlockIdAt($pos->x, $pos->y, $pos->z, $this->trunkBlock);
        $level->setBlockDataAt($pos->x, $pos->y, $pos->z, 3);
    }

    private function placeLeafAt(ChunkManager $worldIn, Vector3 $pos): void
    {
        $material = $worldIn->getBlockAt($pos->x, $pos->y, $pos->z)->getId();

        if ($material === Block::AIR || $material === Block::LEAVES) {
            $worldIn->setBlockIdAt($pos->x, $pos->y, $pos->z, $this->leafBlock);
            $worldIn->setBlockDataAt($pos->x, $pos->y, $pos->z, $this->blockMeta);
        }
    }

}