<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\object;

use pocketmine\block\VanillaBlocks;
use pocketmine\utils\Random;
use pocketmine\world\BlockTransaction;
use pocketmine\world\ChunkManager;
use pocketmine\world\generator\object\SpruceTree;

class BigSpruceTree extends SpruceTree
{

	protected float $leafStartHeightMultiplier;
	protected int $baseLeafRadius;

	protected int $topSize;
	protected int $lRadius;

	public function __construct(float $leafStartHeightMultiplier, int $baseLeafRadius)
	{
		parent::__construct();

		$this->leafStartHeightMultiplier = $leafStartHeightMultiplier;
		$this->baseLeafRadius = $baseLeafRadius;
	}

	public function generateTrunkHeight(Random $random): int
	{
		return $this->treeHeight = $random->nextBoundedInt(15) + 20;
	}

	public function getBlockTransaction(ChunkManager $world, int $x, int $y, int $z, Random $random) : ?BlockTransaction{
		$this->topSize = $this->treeHeight - (int)($this->treeHeight * $this->leafStartHeightMultiplier);
		$this->lRadius = $this->baseLeafRadius + $random->nextBoundedInt(2);

		return parent::getBlockTransaction($world, $x, $y, $z, $random);
	}

	public function placeTrunk(int $x, int $y, int $z, Random $random, int $trunkHeight, BlockTransaction $transaction): void
	{
		$transaction->addBlockAt($x, $y - 1, $z, VanillaBlocks::DIRT());
		$radius = 2;

		for ($yy = 0; $yy < $trunkHeight; ++$yy) {
			for ($xx = 0; $xx < $radius; $xx++) {
				for ($zz = 0; $zz < $radius; $zz++) {
					$block = $transaction->fetchBlockAt($x, $y + $yy, $z);
					if ($this->canOverride($block)) {
						$transaction->addBlockAt($x + $xx, $y + $yy, $z + $zz, $this->trunkBlock);
					}
				}
			}
		}
	}

	protected function placeCanopy(int $x, int $y, int $z, Random $random, BlockTransaction $transaction) : void{
		$radius = $random->nextBoundedInt(2);
		$maxR = 1;
		$minR = 0;

		for ($yy = 0; $yy <= $this->topSize; ++$yy) {
			$yyy = $y + $this->treeHeight - $yy;

			for ($xx = $x - $radius; $xx <= $x + $radius; ++$xx) {
				$xOff = abs($xx - $x);
				for ($zz = $z - $radius; $zz <= $z + $radius; ++$zz) {
					$zOff = abs($zz - $z);
					if ($xOff === $radius && $zOff === $radius && $radius > 0) {
						continue;
					}

					if ($this->canOverride($transaction->fetchBlockAt($xx, $yyy, $zz))) {
						$transaction->addBlockAt($xx, $yyy, $zz, $this->leafBlock);
					}
				}
			}

			if ($radius >= $maxR) {
				$radius = $minR;
				$minR = 1;
				if (++$maxR > $this->lRadius) {
					$maxR = $this->lRadius;
				}
			} else {
				++$radius;
			}
		}
	}

}
