<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes;

class EmptyBiome extends CustomBiome
{

	public function __construct()
	{
		parent::__construct();

		$this->setBaseHeight(0.2);
		$this->setHeightVariation(0.05);

	}

	public function getId(): int
	{
		return CustomBiome::VOID;
	}

	public function getName(): string
	{
		return "Empty";
	}

}