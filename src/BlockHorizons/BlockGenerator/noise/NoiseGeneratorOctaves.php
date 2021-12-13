<?php

namespace BlockHorizons\BlockGenerator\noise;

use BlockHorizons\BlockGenerator\math\CustomRandom;
use SplFixedArray;

class NoiseGeneratorOctaves
{

	/**
	 * Collection of noise generation functions.  Output is combined to produce different octaves of noise.
	 */

	/** @var NoiseGeneratorImproved[] */
	private $generatorCollection;

	/** @var int */
	private $octaves;


	public function __construct(CustomRandom $seed, int $octavesIn)
	{
		$this->octaves = $octavesIn;
		$this->generatorCollection = new SplFixedArray($octavesIn);

		for ($i = 0; $i < $octavesIn; ++$i) {
			$this->generatorCollection[$i] = new NoiseGeneratorImproved($seed);
		}
	}


	/*
	 * pars:(par2,3,4=noiseOffset ; so that adjacent noise segments connect) (pars5,6,7=x,y,zArraySize),(pars8,10,12 =
	 * x,y,z noiseScale)
	 */

	public function generateNoiseOctaves8(array &$noiseArray, int $xOffset, int $zOffset, int $xSize, int $zSize, float $xScale, float $zScale, float $p_76305_10_)
	{
		return $this->generateNoiseOctaves($noiseArray, $xOffset, 10, $zOffset, $xSize, 1, $zSize, $xScale, 1.0, $zScale);
	}

	public function generateNoiseOctaves(array $noiseArray, int $xOffset, int $yOffset, int $zOffset, int $xSize, int $ySize, int $zSize, float $xScale, float $yScale, float $zScale)
	{

		if ($noiseArray == null) {
			$noiseArray = [];
		} else {
			for ($i = 0; $i < count($noiseArray); ++$i) {
				$noiseArray[$i] = 0.0;
			}
		}

		$d3 = 1.0;


		for ($j = 0; $j < $this->octaves; ++$j) {

			$d0 = $xOffset * $d3 * $xScale;
			$d1 = $yOffset * $d3 * $yScale;
			$d2 = $zOffset * $d3 * $zScale;

			$k = floor($d0);

			$l = floor($d2);

			$d0 = $d0 - ((float)$k);

			$d2 = $d2 - ((float)$l);

			$k = $k % 16777216;

			$l = $l % 16777216;

			$d0 = $d0 + ((float)$k);

			$d2 = $d2 + ((float)$l);

			$this->generatorCollection[$j]->populateNoiseArray($noiseArray, $d0, $d1, $d2, $xSize, $ySize, $zSize, $xScale * $d3, $yScale * $d3, $zScale * $d3, $d3);

			$d3 /= 2.0;
		}


		return $noiseArray;
	}

}