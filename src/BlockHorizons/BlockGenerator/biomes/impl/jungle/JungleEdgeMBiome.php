<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\jungle;

class JungleEdgeMBiome extends JungleEdgeBiome
{

	public function __construct()
	{
		parent::__construct();
	}

	public function getName(): string
	{
		return "Jungle Edge M";
	}

}
