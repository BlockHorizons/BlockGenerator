<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\object\BigSpruceTree;
use BlockHorizons\BlockGenerator\object\DarkOakTree;
use pocketmine\block\BlockLegacyIds;
use pocketmine\block\utils\TreeType;
use pocketmine\utils\Random;
use pocketmine\world\ChunkManager;
use pocketmine\world\format\Chunk;
use pocketmine\world\generator\object\BirchTree;
use pocketmine\world\generator\object\JungleTree;
use pocketmine\world\generator\object\OakTree;
use pocketmine\world\generator\object\SpruceTree;

class TreePopulator extends PopulatorCount
{

	public function __construct(
		private TreeType $type,
		private bool  $super = false
	)
	{
	}

	public function populateCount(ChunkManager $world, int $chunkX, int $chunkZ, Random $random): void
	{
		$x = $random->nextRange($chunkX * Chunk::EDGE_LENGTH, ($chunkX * Chunk::EDGE_LENGTH) + Chunk::EDGE_LENGTH - 1);
		$z = $random->nextRange($chunkZ * Chunk::EDGE_LENGTH, ($chunkZ * Chunk::EDGE_LENGTH) + Chunk::EDGE_LENGTH - 1);
		$y = $this->getHighestWorkableBlock($world, $x, $z);

		if ($y < 3) {
			return;
		}

		switch ($this->type) {
			case TreeType::SPRUCE():
				if ($this->super) {
					$tree = new BigSpruceTree(2, 8);
				} else {
					$tree = new SpruceTree();
				}
				break;
			case TreeType::BIRCH():
				$tree = new BirchTree($this->super);
				break;
			case TreeType::JUNGLE():
				$tree = new JungleTree();
				break;
//			case TreeType::ACACIA():
//				$tree = new AcaciaTree();
//				break;
//			case TreeType::DARK_OAK():
//				$tree = new DarkOakTree();
//				return; //TODO
			default:
				$tree = new OakTree();
//				if($random->nextRange(0, 9) === 0){
//					$tree = new BigTree();
//				}else{
//					$tree = new OakTree();
//				}
				break;
		}
		if ($tree->canPlaceObject($world, $x, $y, $z, $random)) {
			$transaction = $tree?->getBlockTransaction($world, $x, $y, $z, $random);
			$transaction?->apply();
		}
	}

	private function getHighestWorkableBlock(ChunkManager $world, int $x, int $z): int
	{
		for ($y = 254; $y > 0; --$y) {
			$b = $world->getBlockAt($x, $y, $z)->getId();
			if ($b === BlockLegacyIds::DIRT || $b === BlockLegacyIds::GRASS || $b === BlockLegacyIds::TALL_GRASS) {
				break;
			} elseif ($b !== BlockLegacyIds::AIR && $b !== BlockLegacyIds::SNOW_LAYER) {
				return -1;
			}
		}

		return ++$y;
	}

}