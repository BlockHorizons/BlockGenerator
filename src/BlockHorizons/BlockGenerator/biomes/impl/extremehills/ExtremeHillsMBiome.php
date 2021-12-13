<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\extremehills;

use BlockHorizons\BlockGenerator\math\CustomRandom;
use BlockHorizons\BlockGenerator\noise\SimplexF;
use JetBrains\PhpStorm\Pure;
use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;

class ExtremeHillsMBiome extends ExtremeHillsPlusBiome
{

	private SimplexF $gravelNoise;

	private SimplexF $iceNoise;

	private bool $isIce = false;
	private bool $isSnowSurface = false;
	private bool $isGravel = false;

	public function __construct(bool $tree = true)
	{
		parent::__construct($tree);

		$this->gravelNoise = new SimplexF(1 / 64, 1, 1 / 4.0, new CustomRandom(0));
		$this->iceNoise = new SimplexF(1 / 64, 1, 1 / 4.0, new CustomRandom(0));

		$this->setBaseHeight(1);
		$this->setHeightVariation(0.5);
	}

	public function getName(): string
	{
		return "Extreme Hills M";
	}

	public function getSurfaceBlock(int $y): Block
	{
		if($this->isIce && $y >= 136) {
			return VanillaBlocks::BLUE_ICE();
		} elseif ($this->isSnowSurface && $y > 126) {
			return VanillaBlocks::SNOW();
		}
		return $this->isGravel ? VanillaBlocks::GRAVEL() : parent::getSurfaceBlock($y);
	}

	#[Pure]
	public function getSurfaceDepth(int $y): int
	{
		if($this->isSnowSurface || $this->isIce) {
			return $this->snowNoise->getNoise2D($y, $y) < -0.1 ? 2 : 3;
		}
		return $this->isGravel ? 4 : parent::getSurfaceDepth($y);
	}

	#[Pure]
	public function getGroundDepth(int $y): int
	{
		return $this->isGravel ? 0 : parent::getGroundDepth($y);
	}

	public function preCover(int $x, int $z): void
	{
		parent::preCover($x, $z);

		$this->isSnowSurface = ($coldNoise = $this->iceNoise->noise2D($x, $z, true)) < -0.09;
		$this->isIce = $coldNoise < - 0.37;
		$this->isGravel = $this->gravelNoise->noise2D($x, $z, true) < -0.45;//-0.75;
	}

	public function doesOverhang(): bool
	{
		return false;
	}
}
