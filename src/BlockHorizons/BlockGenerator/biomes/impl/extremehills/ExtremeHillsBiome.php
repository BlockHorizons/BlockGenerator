<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\extremehills;

use BlockHorizons\BlockGenerator\biomes\type\SnowyBiome;
use BlockHorizons\BlockGenerator\math\CustomRandom;
use BlockHorizons\BlockGenerator\populator\TreePopulator;
use pocketmine\block\Block;
use pocketmine\block\utils\TreeType;
use pocketmine\block\VanillaBlocks;
use pocketmine\world\generator\noise\Simplex;

class ExtremeHillsBiome extends SnowyBiome
{

	protected Simplex $snowNoise;

	protected $isSnow = false;

	public function __construct(bool $tree = true)
	{
		parent::__construct();

		if ($tree) {
			$trees = new TreePopulator(TreeType::SPRUCE());
			$trees->setBaseAmount(2);
			$trees->setRandomAmount(2);
			$this->addPopulator($trees);
		}

		$this->setBaseHeight(1);
		$this->setHeightVariation(0.5);

		$this->snowNoise = new Simplex(new CustomRandom(1337), 8, 100.0 / 8.0, 1.0 / 9000);
	}

	public function getCoverBlock(int $y): Block
	{
		if($y > 92) {
			if($y > 102) {
				return parent::getCoverBlock($y);
			}
			return $this->isSnow ? parent::getCoverBlock($y) : VanillaBlocks::AIR();
		}
		return VanillaBlocks::AIR();
	}

	public function preCover(int $x, int $z): void
	{
		$this->isSnow = $this->snowNoise->noise2D($x, $z, true) > 0;
	}

	public function getName(): string
	{
		return "Extreme Hills";
	}

	public function doesOverhang(): bool
	{
		return true;
	}

}
