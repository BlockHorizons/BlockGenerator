<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes;

use pocketmine\utils\Random;
use pocketmine\world\biome\Biome;
use pocketmine\world\generator\biome\BiomeSelector;

class DebugBiomeSelector extends BiomeSelector
{

	/**
	 * @var array[]
	 */
	private array $biomes;

	public function __construct(Random $random)
	{
		parent::__construct($random);

		$this->biomes = [];
	}

	public function pickBiome($x, $z): Biome
	{
		$x = $x >> 6;
		$z = $z >> 6;
		if (isset($this->biomes[$x][$z])) return $this->biomes[$x][$z];

		$biomes = CustomBiome::getBiomes();
		$biome = $biomes[array_rand(array_filter($biomes->toArray(), fn(?Biome $el) => $el))];

		if (!isset($this->biomes[$x])) $this->biomes[$x] = [];
		$this->biomes[$x][$z] = $biome;

		return $biome;
	}

	protected function lookup(float $temperature, float $rainfall): int
	{
		return 0;
	}

}