<?php

namespace BlockHorizons\BlockGenerator\object;

use BlockHorizons\BlockGenerator\math\FacingHelper;
use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\block\UnknownBlock;
use pocketmine\block\Wood;
use pocketmine\level\ChunkManager;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

class NewJungleTree extends CustomTree
{

	/**
	 * The minimum height of a generated tree.
	 */
	protected $minTreeHeight;

	protected $maxTreeHeight;

	/**
	 * The metadata value of the wood to use in tree generation.
	 */
	protected $metaWood = Wood::JUNGLE;

	/**
	 * The metadata value of the leaves to use in tree generation.
	 */
	protected $metaLeaves = Wood::JUNGLE;

	public function __construct(int $minTreeHeight, int $maxTreeHeight)
	{
		$this->minTreeHeight = $minTreeHeight;
		$this->maxTreeHeight = $maxTreeHeight;
	}

	public function generate(ChunkManager $worldIn, Random $rand, Vector3 $vectorPosition): bool
	{
		$position = new Vector3($vectorPosition->getFloorX(), $vectorPosition->getFloorY(), $vectorPosition->getFloorZ());

		$i = $rand->nextBoundedInt($this->maxTreeHeight) + $this->minTreeHeight;
		$flag = true;

		if ($position->getY() >= 1 && $position->getY() + $i + 1 <= 256) {
			for ($j = $position->getY(); $j <= $position->getY() + 1 + $i; ++$j) {
				$k = 1;

				if ($j === $position->getY()) {
					$k = 0;
				}

				if ($j >= $position->getY() + 1 + $i - 2) {
					$k = 2;
				}

				$pos2 = new Vector3();

				for ($l = $position->getX() - $k; $l <= $position->getX() + $k && $flag; ++$l) {
					for ($i1 = $position->getZ() - $k; $i1 <= $position->getZ() + $k && $flag; ++$i1) {
						if ($j >= 0 && $j < 256) {
							$pos2->setComponents($l, $j, $i1);
							if (!$this->canOverride(BlockFactory::get($worldIn->getBlockIdAt($pos2->x, $pos2->y, $pos2->z)))) {
								$flag = false;
							}
						} else {
							$flag = false;
						}
					}
				}
			}

			if (!$flag) {
				return false;
			} else {
				$down = $position->down();
				$block = $worldIn->getBlockIdAt($down->x, $down->y, $down->z);

				if (($block === Block::GRASS || $block === Block::DIRT || $block === Block::FARMLAND) && $position->getY() < 256 - $i - 1) {
					$worldIn->setBlockIdAt($down->x, $down->y, $down->z, Block::DIRT);
					$k2 = 3;
					$l2 = 0;

					for ($i3 = $position->getY() - 3 + $i; $i3 <= $position->getY() + $i; ++$i3) {
						$i4 = $i3 - ($position->getY() + $i);
						$j1 = 1 - $i4 / 2;

						for ($k1 = $position->getX() - $j1; $k1 <= $position->getX() + $j1; ++$k1) {
							$l1 = $k1 - $position->getX();

							for ($i2 = $position->getZ() - $j1; $i2 <= $position->getZ() + $j1; ++$i2) {
								$j2 = $i2 - $position->getZ();

								if (abs($l1) !== $j1 || abs($j2) !== $j1 || $rand->nextBoundedInt(2) !== 0 && $i4 !== 0) {
									$blockpos = new Vector3($k1, $i3, $i2);
									$id = $worldIn->getBlockIdAt($blockpos->x, $blockpos->y, $blockpos->z);

									if ($id === Block::AIR || $id === Block::LEAVES || $id == Block::VINE) {
										$this->setBlockAndNotifyAdequately($worldIn, $blockpos, Block::get(Block::LEAVES, $this->metaLeaves));
									}
								}
							}
						}
					}

					for ($j3 = 0; $j3 < $i; ++$j3) {
						$up = $position->up($j3);
						$id = $worldIn->getBlockIdAt($up->x, $up->y, $up->z);

						if ($id === Block::AIR || $id === Block::LEAVES || $id === Block::VINE) {
							$this->setBlockAndNotifyAdequately($worldIn, $up, Block::get(Block::LOG, $this->metaWood));

							if ($j3 > 0) {
								if ($rand->nextBoundedInt(3) > 0 && $this->isAirBlock($worldIn, $position->add(-1, $j3, 0))) {
									$this->addVine($worldIn, $position->add(-1, $j3, 0), 8);
								}

								if ($rand->nextBoundedInt(3) > 0 && $this->isAirBlock($worldIn, $position->add(1, $j3, 0))) {
									$this->addVine($worldIn, $position->add(1, $j3, 0), 2);
								}

								if ($rand->nextBoundedInt(3) > 0 && $this->isAirBlock($worldIn, $position->add(0, $j3, -1))) {
									$this->addVine($worldIn, $position->add(0, $j3, -1), 1);
								}

								if ($rand->nextBoundedInt(3) > 0 && $this->isAirBlock($worldIn, $position->add(0, $j3, 1))) {
									$this->addVine($worldIn, $position->add(0, $j3, 1), 4);
								}
							}
						}
					}

					for ($k3 = $position->getY() - 3 + $i; $k3 <= $position->getY() + $i; ++$k3) {
						$j4 = $k3 - ($position->getY() + $i);
						$k4 = 2 - $j4 / 2;
						$pos2 = new Vector3();

						for ($l4 = $position->getX() - $k4; $l4 <= $position->getX() + $k4; ++$l4) {
							for ($i5 = $position->getZ() - $k4; $i5 <= $position->getZ() + $k4; ++$i5) {
								$pos2->setComponents($l4, $k3, $i5);

								if ($worldIn->getBlockIdAt($pos2->x, $pos2->y, $pos2->z) === Block::LEAVES) {
									$blockpos2 = $pos2->west();
									$blockpos3 = $pos2->east();
									$blockpos4 = $pos2->north();
									$blockpos1 = $pos2->south();

									if ($rand->nextBoundedInt(4) === 0 && $worldIn->getBlockIdAt($blockpos2->x, $blockpos2->y, $blockpos2->z) === Block::AIR) {
										$this->addHangingVine($worldIn, $blockpos2, 8);
									}

									if ($rand->nextBoundedInt(4) === 0 && $worldIn->getBlockIdAt($blockpos3->x, $blockpos3->y, $blockpos3->z) === Block::AIR) {
										$this->addHangingVine($worldIn, $blockpos3, 2);
									}

									if ($rand->nextBoundedInt(4) === 0 && $worldIn->getBlockIdAt($blockpos4->x, $blockpos4->y, $blockpos4->z) === Block::AIR) {
										$this->addHangingVine($worldIn, $blockpos4, 1);
									}

									if ($rand->nextBoundedInt(4) === 0 && $worldIn->getBlockIdAt($blockpos1->x, $blockpos1->y, $blockpos1->z) === Block::AIR) {
										$this->addHangingVine($worldIn, $blockpos1, 4);
									}
								}
							}
						}
					}

					if ($rand->nextBoundedInt(5) === 0 && $i > 5) {
						for ($l3 = 0; $l3 < 2; ++$l3) {
							foreach (FacingHelper::HORIZONTAL as $face) {
								if ($rand->nextBoundedInt(4 - $l3) === 0) {
									$enumfacing1 = FacingHelper::opposite($face);
									$this->placeCocoa($worldIn, $rand->nextBoundedInt(3), $position->add(FacingHelper::xOffset($enumfacing1), $i - 5 + $l3, FacingHelper::zOffset($enumfacing1)), $face);
								}
							}
						}
					}

					return true;
				} else {
					return false;
				}
			}
		} else {
			return false;
		}
	}

	public function setBlockAndNotifyAdequately(ChunkManager $level, Vector3 $pos, Block $block): void
	{
		$level->setBlockIdAt($pos->x, $pos->y, $pos->z, $block->getId());
		$level->setBlockDataAt($pos->x, $pos->y, $pos->z, $block->getDamage());
	}

	private function isAirBlock(ChunkManager $level, Vector3 $v): bool
	{
		return $level->getBlockIdAt($v->x, $v->y, $v->z) === Block::AIR;
	}

	private function addVine(ChunkManager $worldIn, Vector3 $pos, int $meta): void
	{
		$this->setBlockAndNotifyAdequately($worldIn, $pos, Block::get(Block::VINE, $meta));
	}

	private function addHangingVine(ChunkManager $worldIn, Vector3 $pos, int $meta): void
	{
		$this->addVine($worldIn, $pos, $meta);
		$i = 4;

		for ($pos = $pos->down(); $i > 0 && $worldIn->getBlockIdAt($pos->x, $pos->y, $pos->z) === Block::AIR; --$i) {
			$this->addVine($worldIn, $pos, $meta);
			$pos = $pos->down();
		}
	}

	private function placeCocoa(ChunkManager $worldIn, int $age, Vector3 $pos, int $side): void
	{
		$meta = $this->getCocoaMeta($age, $side);

		$this->setBlockAndNotifyAdequately($worldIn, $pos, new UnknownBlock(127, $meta));
	}

	private function getCocoaMeta(int $age, int $side): int
	{
		$meta = 0;

		$meta *= $age;

		//3 4 2 5
		switch ($side) {
			case 4:
				$meta++;
				break;
			case 2:
				$meta += 2;
				break;
			case 5:
				$meta += 3;
				break;
		}

		return $meta;
	}

}
