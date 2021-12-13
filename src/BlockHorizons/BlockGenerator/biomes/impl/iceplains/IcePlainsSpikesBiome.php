<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\iceplains;

use BlockHorizons\BlockGenerator\populator\IceSpikesPopulator;
use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;

class IcePlainsSpikesBiome extends IcePlainsBiome
{

	public function __construct()
	{
		parent::__construct();

		$iceSpikes = new IceSpikesPopulator();
		$this->addPopulator($iceSpikes);
	}

	public function getSurfaceBlock(int $y): Block
	{
		return VanillaBlocks::SNOW();
	}

	public function getName(): string
	{
		return "Ice Plains Spikes";
	}

	public function isFreezing(): bool
	{
		return true;
	}

}