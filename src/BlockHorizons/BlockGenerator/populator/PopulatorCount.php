<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\populator;

use pocketmine\math\Vector3;
use pocketmine\utils\Random;
use pocketmine\world\ChunkManager;
use pocketmine\world\generator\populator\Populator;

abstract class PopulatorCount implements Populator
{

	protected int $randomAmount = 1;
	protected int $baseAmount;
	protected float $spreadChance = 0;

	public function setRandomAmount(int $randomAmount): void
	{
		$this->randomAmount = $randomAmount + 1;
	}

	public function setBaseAmount(int $baseAmount): void
	{
		$this->baseAmount = $baseAmount;
	}

	public function setSpreadChance(float $chance): void
	{
		$this->spreadChance = $chance;
	}

	public function populate(ChunkManager $world, int $chunkX, int $chunkZ, Random $random): void
	{
		$count = $this->baseAmount + $random->nextBoundedInt($this->randomAmount);
		for ($i = 0; $i < $count; $i++) {
			$this->populateCount($world, $chunkX, $chunkZ, $random);
		}
	}

	protected abstract function populateCount(ChunkManager $world, int $chunkX, int $chunkZ, Random $random): void;

	protected function spread(int $x, int $y, int $z, ChunkManager $world): ?Vector3
	{
		return null;
	}

}