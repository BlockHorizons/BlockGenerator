<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\populator\helper\EnsureBelow;
use BlockHorizons\BlockGenerator\populator\helper\EnsureCover;
use BlockHorizons\BlockGenerator\populator\helper\EnsureGrassBelow;
use pocketmine\block\Block;
use pocketmine\block\BlockLegacyIds;
use pocketmine\block\VanillaBlocks;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;
use pocketmine\world\ChunkManager;

class SugarcanePopulator extends SurfaceBlockPopulator
{

	protected function spread(int $x, int $y, int $z, ChunkManager $world): ?Vector3
	{
		$j = 0;
		for ($i = -1; $i <= 1; $i++) {
			for ($j = -1; $j <= 1; $j++) {
				$y = $this->getHighestWorkableBlock($world, $x, $z);
				if ($y < 0) break;

				if ($world->getBlockAt($x + $i, $y, $z + $j)->getId() !== BlockLegacyIds::SAND) {
					break;
				}
			}
		}
		if ($y < 0) return null;

		return new Vector3($x + $i, $y, $z + $j);
	}

	protected function canStay(int $x, int $y, int $z, ChunkManager $world): bool
	{
		return EnsureCover::ensureCover($x, $y, $z, $world) && (EnsureGrassBelow::ensureGrassBelow($x, $y, $z, $world) || EnsureBelow::ensureBelow($x, $y, $z, VanillaBlocks::SAND(), $world)) && $this->findWater($x, $y - 1, $z, $world);
	}

	private function findWater(int $x, int $y, int $z, ChunkManager $world): bool
	{
		$count = 0;
		for ($i = $x - 4; $i < ($x + 4); $i++) {
			for ($j = $z - 4; $j < ($z + 4); $j++) {
				if (!$i || !$j || $i > 15 || $j > 15) continue; // edge of chunk
				$b = $world->getBlockAt($i, $y, $j)->getId();
				if ($b === BlockLegacyIds::WATER || $b === BlockLegacyIds::STILL_WATER) {
					$count++;
				}
				if ($count > 10) {
					return true;
				}
			}
		}
		return ($count > 10);
	}

	protected function getBlock(int $x, int $z, Random $random, ChunkManager $world): Block
	{
		return VanillaBlocks::SUGARCANE();
	}
}