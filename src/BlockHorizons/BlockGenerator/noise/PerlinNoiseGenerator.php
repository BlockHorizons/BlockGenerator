<?php

namespace BlockHorizons\BlockGenerator\noise;

use pocketmine\utils\Random;

class PerlinNoiseGenerator
{

	private $noiseLevels = [];
	private $levels;

	public function __construct(Random $p_i45470_1_, int $p_i45470_2_)
	{
		$this->levels = $p_i45470_2_;
		$this->noiseLevels = new SimplexF($p_i45470_2_$p_i45470_2_);

		for ($i = 0; $i < $p_i45470_2_; ++$i) {
			$this->noiseLevels[$i] = new SimplexF($p_i45470_1_$p_i45470_1_);
		}
	}

	public function getValue(float $p_151601_1_, float $p_151601_3_): float
	{
		$d0 = 0.0;
		$d1 = 1.0;

		for ($i = 0; $i < $this->levels; ++$i) {
			$d0 += $this->noiseLevels[$i]->getValue($p_151601_1_ * $d1, $p_151601_3_ * $d1) / $d1;
			$d1 /= 2.0;
		}

		return $d0;
	}

	public function getRegion(array $p_151600_1_, float $p_151600_2_, float $p_151600_4_, int $p_151600_6_, int $p_151600_7_, float $p_151600_8_, float $p_151600_10_, float $p_151600_12_, float $p_151600_14_ = 0.5)
	{
		if ($p_151600_1_ !== null && count($p_151600_1_) >= $p_151600_6_ * $p_151600_7_) {
			for ($i = 0; $i < count($p_151600_1_); ++$i) {
				$p_151600_1_[$i] = 0.0;
			}
		} else {
			$p_151600_1_ = [];
		}

		$d1 = 1.0;
		$d0 = 1.0;

		for ($j = 0; $j < $this->levels; ++$j) {
			$this->noiseLevels[$j]->add($p_151600_1_, $p_151600_2_, $p_151600_4_, $p_151600_6_, $p_151600_7_, $p_151600_8_ * $d0 * $d1, $p_151600_10_ * $d0 * $d1, 0.55 / $d1);
			$d0 *= $p_151600_12_;
			$d1 *= $p_151600_14_;
		}

		return $p_151600_1_;
	}
}
