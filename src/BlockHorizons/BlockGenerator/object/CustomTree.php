<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\object;

use pocketmine\utils\Random;
use pocketmine\world\BlockTransaction;
use pocketmine\world\ChunkManager;
use pocketmine\world\generator\object\Tree;

abstract class CustomTree extends Tree
{

	public function getBlockTransaction(ChunkManager $world, int $x, int $y, int $z, Random $random) : ?BlockTransaction
	{
		// TODO: Implement getBlockTransaction() method.
	}

	protected function generateTrunkHeight(Random $random) : int
	{
		//
	}

	protected function placeTrunk(int $x, int $y, int $z, Random $random, int $trunkHeight, BlockTransaction $transaction) : void
	{
		//
	}

	protected function placeCanopy(int $x, int $y, int $z, Random $random, BlockTransaction $transaction) : void
	{
		//
	}

}