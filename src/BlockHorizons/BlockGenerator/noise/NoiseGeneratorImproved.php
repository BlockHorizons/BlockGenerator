<?php

namespace BlockHorizons\BlockGenerator\noise;

use BlockHorizons\BlockGenerator\math\CustomRandom;

class NoiseGeneratorImproved
{

	const GRAD_X = [
		1.0, -1.0, 1.0, -1.0,
		1.0, -1.0, 1.0, -1.0,
		0.0, 0.0, 0.0, 0.0, 1.0,
		0.0, -1.0, 0
	];
	const GRAD_Y = [
		1.0, 1.0, -1.0, -1.0,
		0.0, 0.0, 0.0, 0.0,
		1.0, -1.0, 1.0, -1.0,
		1.0, -1.0, 1.0, -1.0
	];
	const GRAD_Z = [
		0.0, 0.0, 0.0, 0.0,
		1.0, 1.0, -1.0, -1.0,
		1.0, 1.0, -1.0, -1.0,
		0.0, 1.0, 0.0, -1.0
	];
	const GRAD_2X = [
		1.0, -1.0, 1.0, -1.0,
		1.0, -1.0, 1.0, -1.0,
		0.0, 0.0, 0.0, 0.0,
		1.0, 0.0, -1.0, 0.0
	];
	const GRAD_2Z = [
		0.0, 0.0, 0.0, 0.0,
		1.0, 1.0, -1.0, -1.0,
		1.0, 1.0, -1.0, -1.0,
		0.0, 1.0, 0.0, -1.0
	];
	/** @var float */
	public $xCoord, $yCoord, $zCoord;
	private $permutations;

	public function __construct($p_i45469_1_ = null)
	{
		if (is_integer($p_i45469_1_)) $p_i45469_1_ = new CustomRandom($p_i45469_1_);
		if (!$p_i45469_1_) $p_i45469_1_ = new CustomRandom(microtime(true));
		$this->permutations = []; // was fixed to 512

		for ($i = 0; $i < 512; $i++) $this->permutations[$i] = $i;

		$this->xCoord = $p_i45469_1_->nextFloat() * 256.0;
		$this->yCoord = $p_i45469_1_->nextFloat() * 256.0;
		$this->zCoord = $p_i45469_1_->nextFloat() * 256.0;

		for ($l = 0; $l < 512; ++$l) {

			$j = $p_i45469_1_->nextBoundedInt(512 - $l) + $l;

			$k = $this->permutations[$l];

			$this->permutations[$l] = $this->permutations[$j];

			$this->permutations[$j] = $k;

			$this->permutations[$l + 512] = $this->permutations[$l];

		}

	}

	public function populateNoiseArray(array &$noiseArray, float $xOffset, float $yOffset, float $zOffset, int $xSize, int $ySize, int $zSize, float $xScale, float $yScale, float $zScale, float $noiseScale): void
	{

		if ($ySize == 1) {
			$i5 = 0;
			$j5 = 0;
			$j = 0;
			$k5 = 0;
			$d14 = 0.0;
			$d15 = 0.0;
			$l5 = 0;
			$d16 = 1.0 / $noiseScale;

			for ($j2 = 0; $j2 < $xSize; ++$j2) {
				$d17 = $xOffset + (float)$j2 * $xScale + $this->xCoord;
				$i6 = (int)$d17;

				if ($d17 < (float)$i6) {
					--$i6;
				}

				$k2 = $i6 & 255;
				$d17 = $d17 - (float)$i6;
				$d18 = $d17 * $d17 * $d17 * ($d17 * ($d17 * 6.0 - 15.0) + 10.0);

				for ($j6 = 0; $j6 < $zSize; ++$j6) {
					$d19 = $zOffset + (float)$j6 * $zScale + $this->zCoord;
					$k6 = (int)$d19;
					if ($d19 < (float)$k6) {
						--$k6;
					}

					$l6 = $k6 & 255;
					$d19 = $d19 - (float)$k6;
					$d20 = $d19 * $d19 * $d19 * ($d19 * ($d19 * 6.0 - 15.0) + 10.0);
					$i5 = $this->permutations[$k2] + 0;
					$j5 = $this->permutations[$i5] + $l6;
					$j = $this->permutations[$k2 + 1] + 0;
					$k5 = $this->permutations[$j] + $l6;
					$d14 = $this->lerp($d18, $this->grad2($this->permutations[$j5], $d17, $d19), $this->grad($this->permutations[$k5], $d17 - 1.0, 0.0, $d19));
					$d15 = $this->lerp($d18, $this->grad($this->permutations[$j5 + 1], $d17, 0.0, $d19 - 1.0), $this->grad($this->permutations[$k5 + 1], $d17 - 1.0, 0.0, $d19 - 1.0));
					$d21 = $this->lerp($d20, $d14, $d15);
					$i7 = $l5++;
					if (!isset($noiseArray[$i7])) $noiseArray[$i7] = 0;
					$noiseArray[$i7] += $d21 * $d16;
				}
			}
		} else {
			$i = 0;
			$d0 = 1.0 / $noiseScale;
			$k = -1;
			$l = 0;
			$i1 = 0;
			$j1 = 0;
			$k1 = 0;
			$l1 = 0;
			$i2 = 0;
			$d1 = 0.0;
			$d2 = 0.0;
			$d3 = 0.0;
			$d4 = 0.0;

			for ($l2 = 0; $l2 < $xSize; ++$l2) {
				$d5 = $xOffset + (float)$l2 * $xScale + $this->xCoord;
				$i3 = (int)$d5;

				if ($d5 < (float)$i3) {
					--$i3;
				}

				$j3 = $i3 & 255;
				$d5 = $d5 - (float)$i3;
				$d6 = $d5 * $d5 * $d5 * ($d5 * ($d5 * 6.0 - 15.0) + 10.0);

				for ($k3 = 0; $k3 < $zSize; ++$k3) {
					$d7 = $zOffset + (float)$k3 * $zScale + $this->zCoord;
					$l3 = (int)$d7;

					if ($d7 < (float)$l3) {
						--$l3;
					}

					$i4 = $l3 & 255;
					$d7 = $d7 - (float)$l3;
					$d8 = $d7 * $d7 * $d7 * ($d7 * ($d7 * 6.0 - 15.0) + 10.0);

					for ($j4 = 0; $j4 < $ySize; ++$j4) {
						$d9 = $yOffset + (float)$j4 * $yScale + $this->yCoord;
						$k4 = (int)$d9;

						if ($d9 < (float)$k4) {
							--$k4;
						}

						$l4 = $k4 & 255;
						$d9 = $d9 - (float)$k4;
						$d10 = $d9 * $d9 * $d9 * ($d9 * ($d9 * 6.0 - 15.0) + 10.0);


						if ($j4 == 0 || $l4 != $k) {
							$k = $l4;
							$l = $this->permutations[$j3] + $l4;
							$i1 = $this->permutations[$l] + $i4;
							$j1 = $this->permutations[$l + 1] + $i4;
							$k1 = $this->permutations[$j3 + 1] + $l4;
							$l1 = $this->permutations[$k1] + $i4;
							$i2 = $this->permutations[$k1 + 1] + $i4;
							$d1 = $this->lerp($d6, $this->grad($this->permutations[$i1], $d5, $d9, $d7), $this->grad($this->permutations[$l1], $d5 - 1.0, $d9, $d7));
							$d2 = $this->lerp($d6, $this->grad($this->permutations[$j1], $d5, $d9 - 1.0, $d7), $this->grad($this->permutations[$i2], $d5 - 1.0, $d9 - 1.0, $d7));
							$d3 = $this->lerp($d6, $this->grad($this->permutations[$i1 + 1], $d5, $d9, $d7 - 1.0), $this->grad($this->permutations[$l1 + 1], $d5 - 1.0, $d9, $d7 - 1.0));
							$d4 = $this->lerp($d6, $this->grad($this->permutations[$j1 + 1], $d5, $d9 - 1.0, $d7 - 1.0), $this->grad($this->permutations[$i2 + 1], $d5 - 1.0, $d9 - 1.0, $d7 - 1.0));
						}
						$d11 = $this->lerp($d10, $d1, $d2);
						$d12 = $this->lerp($d10, $d3, $d4);
						$d13 = $this->lerp($d8, $d11, $d12);
						$j7 = $i++;
						if (!isset($noiseArray[$j7])) $noiseArray[$j7] = 0;
						$noiseArray[$j7] += $d13 * $d0;
					}
				}
			}
		}
	}

	public function lerp(float $p_76311_1_, float $p_76311_3_, float $p_76311_5_): float
	{
		return $p_76311_3_ + $p_76311_1_ * ($p_76311_5_ - $p_76311_3_);
	}

	public function grad2(int $p_76309_1_, float $p_76309_2_, float $p_76309_4_): float
	{
		$i = $p_76309_1_ & 15;
		return self::GRAD_2X[$i] * $p_76309_2_ + self::GRAD_2Z[$i] * $p_76309_4_;
	}


	/*

	 * noiseArray should be xSize*ySize*zSize in size

	 */

	public function grad(int $p_76310_1_, float $p_76310_2_, float $p_76310_4_, float $p_76310_6_): float
	{

		$i = $p_76310_1_ & 15;

		return self::GRAD_X[$i] * $p_76310_2_ + self::GRAD_Y[$i] * $p_76310_4_ + self::GRAD_Z[$i] * $p_76310_6_;

	}

}