<?php

namespace BlockHorizons\BlockGenerator\biomes;

use pocketmine\level\biome\Biome;
use pocketmine\level\generator\biome\BiomeSelector;
use pocketmine\level\generator\noise\Simplex;
use pocketmine\utils\Random;

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
        if(isset($this->biomes[$x][$z])) return $this->biomes[$x][$z];

        $biomes = CustomBiome::getBiomes();
        $biome = $biomes[array_rand(array_filter($biomes->toArray(), function($el){
            if($el) return $el;
        }))];

        if(!isset($this->biomes[$x])) $this->biomes[$x] = [];
        $this->biomes[$x][$z] = $biome;

        return $biome;
    }

    protected function lookup(float $temperature, float $rainfall): int
    {
        return 0;
    }

}