<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\noise;

use JetBrains\PhpStorm\Pure;
use pocketmine\utils\Random;
use pocketmine\world\generator\noise\Noise;

class PerlinF extends Noise
{

	protected array $permutations = [];
	protected int|float $offsetX = 0;
	protected int|float $offsetY = 0;
	protected int|float $offsetZ = 0;

	public function __construct(Random $random, int $octaves, float $persistence, float $expansion)
	{
		parent::__construct($octaves, $persistence, $expansion);

		$this->offsetX = $random->nextFloat() * 256;
		$this->offsetY = $random->nextFloat() * 256;
		$this->offsetZ = $random->nextFloat() * 256;
		$this->permutations = [];
		for ($i = 0; $i < 256; ++$i) {
			$this->permutations[$i] = $random->nextBoundedInt(256);
		}
		for ($i = 0; $i < 256; ++$i) {
			$pos = $random->nextBoundedInt(256 - $i) + $i;
			$old = $this->permutations[$i];
			$this->permutations[$i] = $this->permutations[$pos];
			$this->permutations[$pos] = $old;
			$this->permutations[$i + 256] = $this->permutations[$i];
		}
	}

	#[Pure]
	public function getNoise2D($x, $y): float
	{
		return $this->getNoise3D($x, $y, 0);
	}

	#[Pure]
	public function getNoise3D($x, $y, $z): float
	{
		$x += $this->offsetX;
		$y += $this->offsetY;
		$z += $this->offsetZ;

		$floorX = (int)$x;
		$floorY = (int)$y;
		$floorZ = (int)$z;

		$x1 = $floorX & 0xFF;
		$y1 = $floorY & 0xFF;
		$z1 = $floorZ & 0xFF;

		$x -= $floorX;
		$y -= $floorY;
		$z -= $floorZ;

		//Fade curves
		//fX = fade(x);
		//fY = fade(y);
		//fZ = fade(z);
		$fX = $x * $x * $x * ($x * ($x * 6 - 15) + 10);
		$fY = $y * $y * $y * ($y * ($y * 6 - 15) + 10);
		$fZ = $z * $z * $z * ($z * ($z * 6 - 15) + 10);

		//Cube corners
		$A = $this->permutations[$x1] + $y1;
		$B = $this->permutations[$x1 + 1] + $y1;

		$AA = $this->permutations[$A] + $z1;
		$AB = $this->permutations[$A + 1] + $z1;
		$BA = $this->permutations[$B] + $z1;
		$BB = $this->permutations[$B + 1] + $z1;

		$AA1 = self::grad($this->permutations[$AA], $x, $y, $z);
		$BA1 = self::grad($this->permutations[$BA], $x - 1, $y, $z);
		$AB1 = self::grad($this->permutations[$AB], $x, $y - 1, $z);
		$BB1 = self::grad($this->permutations[$BB], $x - 1, $y - 1, $z);
		$AA2 = self::grad($this->permutations[$AA + 1], $x, $y, $z - 1);
		$BA2 = self::grad($this->permutations[$BA + 1], $x - 1, $y, $z - 1);
		$AB2 = self::grad($this->permutations[$AB + 1], $x, $y - 1, $z - 1);
		$BB2 = self::grad($this->permutations[$BB + 1], $x - 1, $y - 1, $z - 1);

		$xLerp11 = $AA1 + $fX * ($BA1 - $AA1);

		$zLerp1 = $xLerp11 + $fY * ($AB1 + $fX * ($BB1 - $AB1) - $xLerp11);

		$xLerp21 = $AA2 + $fX * ($BA2 - $AA2);

		return $zLerp1 + $fZ * ($xLerp21 + $fY * ($AB2 + $fX * ($BB2 - $AB2) - $xLerp21) - $zLerp1);
	}

	public static function grad($hash, $x, $y, $z): float
	{
		$hash &= 15;
		$u = $hash < 8 ? $x : $y;
		$v = $hash < 4 ? $y : (($hash === 12 || $hash === 14) ? $x :
			$z);

		return (($hash & 1) === 0 ? $u : -$u) + (($hash & 2) === 0 ? $v : -$v);
	}

}
