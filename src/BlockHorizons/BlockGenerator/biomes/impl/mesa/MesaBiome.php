<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\mesa;

use BlockHorizons\BlockGenerator\biomes\type\CoveredBiome;
use BlockHorizons\BlockGenerator\math\CustomRandom;
use BlockHorizons\BlockGenerator\noise\SimplexF;
use BlockHorizons\BlockGenerator\populator\CactusPopulator;
use BlockHorizons\BlockGenerator\populator\DeadBushPopulator;
use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\block\VanillaBlocks;
use pocketmine\utils\Random;

class MesaBiome extends CoveredBiome
{

	public int $randY = 0;
	public int $redSandThreshold = 0;
	public int $currMeta = 0;
	public int $startY = 0;

	public bool $isRedSand = false;

	protected array $colorLayer = [];

	protected SimplexF $redSandNoise;
	protected SimplexF $colorNoise;
	protected SimplexF $moundNoise;

	protected int $moundHeight;

	public function __construct()
	{
		parent::__construct();

		$cactus = new CactusPopulator();
		$cactus->setBaseAmount(1);
		$cactus->setRandomAmount(1);
		$this->addPopulator($cactus);

		$deadBush = new DeadBushPopulator();
		$deadBush->setBaseAmount(3);
		$deadBush->setRandomAmount(2);
		$this->addPopulator($deadBush);

		$this->colorLayer = [];
		$this->redSandNoise = new SimplexF(1 / 4.0, 2, 1 / 4, new CustomRandom(937478913));
		$this->colorNoise = new SimplexF(1 / 32.0, 2, 1 / 4, new CustomRandom(193759875));
		$this->moundNoise = new SimplexF($this->getMoundFrequency(), 2, 1 / 4, new CustomRandom(347228794));

		$random = new CustomRandom(29864);

		for ($i = 0; $i < 64; $i++) {
			$this->colorLayer[$i] = -1;
		}
		$this->setRandomLayerColor($random, 14, 1); // orange
		$this->setRandomLayerColor($random, 8, 4); // yellow
		$this->setRandomLayerColor($random, 7, 12); // brown
		$this->setRandomLayerColor($random, 10, 14); // red
		for ($i = 0, $j = 0; $i < $random->nextBoundedInt(3) + 3; $i++) {
			$j += $random->nextBoundedInt(6) + 4;
			if ($j >= count($this->colorLayer) - 3) {
				break;
			}
			if ($random->nextBoundedInt(2) === 0 || $j < count($this->colorLayer) - 1 && $random->nextBoundedInt(2) === 0) {
				$this->colorLayer[$j - 1] = 8; // light gray
			} else {
				$this->colorLayer[$j] = 0; // white
			}
		}
		$this->setMoundHeight(17);

		$this->setBaseHeight(2.0);
		$this->setHeightVariation(1.5);
	}

	protected function getMoundFrequency(): float
	{
		return 1 / 128.0;
	}

	private function setRandomLayerColor(Random $random, int $sliceCount, int $color): void
	{
		for ($i = 0; $i < $random->nextBoundedInt(4) + $sliceCount; $i++) {
			$j = $random->nextBoundedInt(count($this->colorLayer));
			$k = 0;
			while ($k < $random->nextBoundedInt(2) + 1 && $j < count($this->colorLayer)) {
				$this->colorLayer[$j++] = $color;
				$k++;
			}
		}
	}

	public function setMoundHeight(int $height): void
	{
		$this->moundHeight = $height;
	}

	public function getSurfaceDepth(int $y): int
	{
		$this->isRedSand = $y < $this->redSandThreshold;
		$this->startY = $y;

		return $this->isRedSand ? 3 : $y - 66;
	}

	public function getSurfaceBlock(int $y): Block
	{
		if ($this->isRedSand) {
			return VanillaBlocks::RED_SAND();
		} else {
			$this->currMeta = $this->colorLayer[($y + $this->randY) & 0x3F];
			return $this->currMeta === -1
				? BlockFactory::getInstance()->get(172, 0)
				: BlockFactory::getInstance()->get(159, $this->currMeta);
		}
	}

	public function getGroundDepth(int $y): int
	{
		return $this->isRedSand ? 2 : 0;
	}

	public function getGroundBlock(int $y): Block
	{
		return VanillaBlocks::RED_SANDSTONE();
	}

	public function getName(): string
	{
		return "Mesa";
	}

	public function preCover(int $x, int $z): void
	{
		$this->randY = (int)round(($this->colorNoise->noise2D($x, $z, true) + 1) * 1.5);

		$this->redSandThreshold = 71 + (int)round(($this->redSandNoise->noise2D($x, $z, true) + 1) * 1.5);
	}

	public function getHeightOffset(int $x, int $z): int
	{
		$n = $this->moundNoise->noise2D($x, $z, true);
		$a = self::minHill();
		return ($n > $a && $n < $a + 0.2) ? (int)(($n - $a) * 5 * $this->moundHeight) : ($n < $a + 0.1 ? 0 : $this->moundHeight);
	}

	protected function minHill(): float
	{
		return -0.1;
	}
}
