<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\forest;

class ForestHillsBiome extends ForestBiome
{

	public function __construct(int $type = self::TYPE_NORMAL)
	{
		parent::__construct($type);

		$this->setBaseHeight(0.45);
		$this->setHeightVariation(0.3);
	}

	public function getName(): string
	{
		return match ($this->type) {
			self::TYPE_BIRCH => "Birch Forest Hills",
			self::TYPE_BIRCH_TALL => "Birch Forest Hills M",
			default => "Forest Hills",
		};
	}

}
