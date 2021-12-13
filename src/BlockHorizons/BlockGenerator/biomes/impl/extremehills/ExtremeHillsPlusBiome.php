<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\extremehills;

class ExtremeHillsPlusBiome extends ExtremeHillsBiome
{

	public function __construct(bool $tree = true)
	{
		parent::__construct($tree);

		$this->setBaseHeight(1);
		$this->setHeightVariation(0.5);
	}

	public function getName(): string
	{
		return "Extreme Hills+";
	}

}
