<?php

namespace BlockHorizons\BlockGenerator\biomes;

use BlockHorizons\BlockGenerator\biomes\impl\beach\BeachBiome;
use BlockHorizons\BlockGenerator\biomes\impl\beach\ColdBeachBiome;
use BlockHorizons\BlockGenerator\biomes\impl\desert\DesertBiome;
use BlockHorizons\BlockGenerator\biomes\impl\desert\DesertHillsBiome;
use BlockHorizons\BlockGenerator\biomes\impl\desert\DesertMBiome;
use BlockHorizons\BlockGenerator\biomes\impl\extremehills\ExtremeHillsBiome;
use BlockHorizons\BlockGenerator\biomes\impl\extremehills\ExtremeHillsEdgeBiome;
use BlockHorizons\BlockGenerator\biomes\impl\extremehills\ExtremeHillsMBiome;
use BlockHorizons\BlockGenerator\biomes\impl\extremehills\ExtremeHillsPlusBiome;
use BlockHorizons\BlockGenerator\biomes\impl\extremehills\ExtremeHillsPlusMBiome;
use BlockHorizons\BlockGenerator\biomes\impl\extremehills\StoneBeachBiome;
use BlockHorizons\BlockGenerator\biomes\impl\forest\FlowerForestBiome;
use BlockHorizons\BlockGenerator\biomes\impl\forest\ForestBiome;
use BlockHorizons\BlockGenerator\biomes\impl\forest\ForestHillsBiome;
use BlockHorizons\BlockGenerator\biomes\impl\iceplains\IcePlainsBiome;
use BlockHorizons\BlockGenerator\biomes\impl\iceplains\IcePlainsSpikesBiome;
use BlockHorizons\BlockGenerator\biomes\impl\jungle\JungleBiome;
use BlockHorizons\BlockGenerator\biomes\impl\jungle\JungleEdgeBiome;
use BlockHorizons\BlockGenerator\biomes\impl\jungle\JungleEdgeMBiome;
use BlockHorizons\BlockGenerator\biomes\impl\jungle\JungleHillsBiome;
use BlockHorizons\BlockGenerator\biomes\impl\jungle\JungleMBiome;
use BlockHorizons\BlockGenerator\biomes\impl\mesa\MesaBiome;
use BlockHorizons\BlockGenerator\biomes\impl\mesa\MesaBryceBiome;
use BlockHorizons\BlockGenerator\biomes\impl\mesa\MesaPlateauBiome;
use BlockHorizons\BlockGenerator\biomes\impl\mesa\MesaPlateauFBiome;
use BlockHorizons\BlockGenerator\biomes\impl\mesa\MesaPlateauFMBiome;
use BlockHorizons\BlockGenerator\biomes\impl\mesa\MesaPlateauMBiome;
use BlockHorizons\BlockGenerator\biomes\impl\mushroom\MushroomIslandBiome;
use BlockHorizons\BlockGenerator\biomes\impl\mushroom\MushroomIslandShoreBiome;
use BlockHorizons\BlockGenerator\biomes\impl\ocean\DeepOceanBiome;
use BlockHorizons\BlockGenerator\biomes\impl\ocean\FrozenOceanBiome;
use BlockHorizons\BlockGenerator\biomes\impl\ocean\OceanBiome;
use BlockHorizons\BlockGenerator\biomes\impl\plains\PlainsBiome;
use BlockHorizons\BlockGenerator\biomes\impl\plains\SunflowerPlainsBiome;
use BlockHorizons\BlockGenerator\biomes\impl\river\FrozenRiverBiome;
use BlockHorizons\BlockGenerator\biomes\impl\river\RiverBiome;
use BlockHorizons\BlockGenerator\biomes\impl\roofedforest\RoofedForestBiome;
use BlockHorizons\BlockGenerator\biomes\impl\roofedforest\RoofedForestMBiome;
use BlockHorizons\BlockGenerator\biomes\impl\savanna\SavannaBiome;
use BlockHorizons\BlockGenerator\biomes\impl\savanna\SavannaMBiome;
use BlockHorizons\BlockGenerator\biomes\impl\savanna\SavannaPlateauBiome;
use BlockHorizons\BlockGenerator\biomes\impl\savanna\SavannaPlateauMBiome;
use BlockHorizons\BlockGenerator\biomes\impl\swamp\SwampBiome;
use BlockHorizons\BlockGenerator\biomes\impl\swamp\SwamplandMBiome;
use BlockHorizons\BlockGenerator\biomes\impl\taiga\ColdTaigaBiome;
use BlockHorizons\BlockGenerator\biomes\impl\taiga\ColdTaigaHillsBiome;
use BlockHorizons\BlockGenerator\biomes\impl\taiga\ColdTaigaMBiome;
use BlockHorizons\BlockGenerator\biomes\impl\taiga\MegaSpruceTaigaBiome;
use BlockHorizons\BlockGenerator\biomes\impl\taiga\MegaTaigaBiome;
use BlockHorizons\BlockGenerator\biomes\impl\taiga\MegaTaigaHillsBiome;
use BlockHorizons\BlockGenerator\biomes\impl\taiga\TaigaBiome;
use BlockHorizons\BlockGenerator\biomes\impl\taiga\TaigaHillsBiome;
use BlockHorizons\BlockGenerator\biomes\impl\taiga\TaigaMBiome;
use pocketmine\level\biome\Biome;
use pocketmine\level\biome\UnknownBiome;


abstract class CustomBiome extends Biome
{

    public const
        OCEAN = 0,
        PLAINS = 1,
        DESERT = 2,
        EXTREME_HILLS = 3,
        FOREST = 4,
        TAIGA = 5,
        SWAMP = 6,
        RIVER = 7,//
        HELL = 8,
        END = 9,
        FROZEN_OCEAN = 10, //DOES NOT GENERATE NATUALLY
        FROZEN_RIVER = 11,
        ICE_PLAINS = 12,
        MUSHROOM_ISLAND = 14,//
        MUSHROOM_ISLAND_SHORE = 15,
        BEACH = 16,
        DESERT_HILLS = 17,
        FOREST_HILLS = 18,
        TAIGA_HILLS = 19,
        EXTREME_HILLS_EDGE = 20, //DOES NOT GENERATE NATUALLY
        JUNGLE = 21,
        JUNGLE_HILLS = 22,
        JUNGLE_EDGE = 23,
        DEEP_OCEAN = 24,
        STONE_BEACH = 25,
        COLD_BEACH = 26,
        BIRCH_FOREST = 27,
        BIRCH_FOREST_HILLS = 28,
        ROOFED_FOREST = 29,
        COLD_TAIGA = 30,
        COLD_TAIGA_HILLS = 31,
        MEGA_TAIGA = 32,
        MEGA_TAIGA_HILLS = 33,
        EXTREME_HILLS_PLUS = 34,
        SAVANNA = 35,
        SAVANNA_PLATEAU = 36,
        MESA = 37,
        MESA_PLATEAU_F = 38,
        MESA_PLATEAU = 39,
        //    All biomes below this comment are mutated variants of existing biomes
        SUNFLOWER_PLAINS = 129,
        DESERT_M = 130,
        EXTREME_HILLS_M = 131,
        FLOWER_FOREST = 132,
        TAIGA_M = 133,
        SWAMPLAND_M = 134,
        //no, the following jumps in IDs are NOT mistakes
        ICE_PLAINS_SPIKES = 140,
        JUNGLE_M = 149,
        JUNGLE_EDGE_M = 151,
        BIRCH_FOREST_M = 155,
        BIRCH_FOREST_HILLS_M = 156,
        ROOFED_FOREST_M = 157,
        COLD_TAIGA_M = 158,
        MEGA_SPRUCE_TAIGA = 160,
        EXTREME_HILLS_PLUS_M = 162,
        SAVANNA_M = 163,
        SAVANNA_PLATEAU_M = 164,
        MESA_BRYCE = 165,
        MESA_PLATEAU_F_M = 166,
        MESA_PLATEAU_M = 167,
        VOID = 127;
    private static $customBiomes;
    /** @var float */
    protected $baseHeight = 0.1;
    protected $heightVariation = 0.3;

    public function __construct()
    {

    }

    public static function init(): void
    {
        self::$customBiomes = new \SplFixedArray(self::MAX_BIOMES);

        self::register(self::PLAINS, new PlainsBiome());
        self::register(self::BEACH, new BeachBiome());
        self::register(self::DESERT, new DesertBiome()); //
        self::register(self::DESERT_M, new DesertMBiome());
        self::register(self::DESERT_HILLS, new DesertHillsBiome());
        self::register(self::COLD_BEACH, new ColdBeachBiome());
        self::register(self::EXTREME_HILLS, new ExtremeHillsBiome());
        self::register(self::EXTREME_HILLS_EDGE, new ExtremeHillsEdgeBiome());
        self::register(self::EXTREME_HILLS_M, new ExtremeHillsMBiome());
        self::register(self::EXTREME_HILLS_PLUS, new ExtremeHillsPlusBiome());
        self::register(self::EXTREME_HILLS_PLUS_M, new ExtremeHillsPlusMBiome());
        self::register(self::STONE_BEACH, new StoneBeachBiome());
        self::register(self::TAIGA, new TaigaBiome());
        self::register(self::TAIGA_HILLS, new TaigaHillsBiome());
        self::register(self::TAIGA_M, new TaigaMBiome());
        self::register(self::COLD_TAIGA_HILLS, new ColdTaigaHillsBiome());
        self::register(self::COLD_TAIGA, new ColdTaigaBiome());
        self::register(self::COLD_TAIGA_M, new ColdTaigaMBiome());
        self::register(self::MEGA_SPRUCE_TAIGA, new MegaSpruceTaigaBiome());
        self::register(self::MEGA_TAIGA, new MegaTaigaBiome());
        self::register(self::MEGA_TAIGA_HILLS, new MegaTaigaHillsBiome());
        self::register(self::SAVANNA, new SavannaBiome());
        self::register(self::SAVANNA_M, new SavannaMBiome());
        self::register(self::SAVANNA_PLATEAU, new SavannaPlateauBiome());
        self::register(self::SAVANNA_PLATEAU_M, new SavannaPlateauMBiome());
        self::register(self::RIVER, new RiverBiome());
        self::register(self::FROZEN_RIVER, new FrozenRiverBiome());
        self::register(self::SUNFLOWER_PLAINS, new SunflowerPlainsBiome());
        self::register(self::MESA, new MesaBiome());
        self::register(self::MESA_BRYCE, new MesaBryceBiome());
        self::register(self::MESA_PLATEAU, new MesaPlateauBiome());
        self::register(self::MESA_PLATEAU_F, new MesaPlateauFBiome());
        self::register(self::MESA_PLATEAU_M, new MesaPlateauMBiome());
        self::register(self::MESA_PLATEAU_F_M, new MesaPlateauFMBiome());
        self::register(self::OCEAN, new OceanBiome());
        self::register(self::DEEP_OCEAN, new DeepOceanBiome());
        self::register(self::FROZEN_OCEAN, new FrozenOceanBiome());
        self::register(self::ICE_PLAINS, new IcePlainsBiome());
        self::register(self::ICE_PLAINS_SPIKES, new IcePlainsSpikesBiome());
        self::register(self::FOREST, new ForestBiome());
        self::register(self::FOREST_HILLS, new ForestHillsBiome());
        self::register(self::BIRCH_FOREST, new ForestBiome(ForestBiome::TYPE_BIRCH));
        self::register(self::BIRCH_FOREST_HILLS, new ForestHillsBiome(ForestBiome::TYPE_BIRCH));
        self::register(self::FLOWER_FOREST, new FlowerForestBiome());
        self::register(self::BIRCH_FOREST_M, new ForestBiome(ForestBiome::TYPE_BIRCH_TALL));
        self::register(self::BIRCH_FOREST_HILLS_M, new ForestHillsBiome(ForestBiome::TYPE_BIRCH_TALL));
        self::register(self::JUNGLE, new JungleBiome());
        self::register(self::JUNGLE_M, new JungleMBiome());
        self::register(self::JUNGLE_EDGE, new JungleEdgeBiome());
        self::register(self::JUNGLE_EDGE_M, new JungleEdgeMBiome());
        self::register(self::JUNGLE_HILLS, new JungleHillsBiome());
        self::register(self::MUSHROOM_ISLAND, new MushroomIslandBiome());
        self::register(self::MUSHROOM_ISLAND_SHORE, new MushroomIslandShoreBiome());
        self::register(self::SWAMP, new SwampBiome());
        self::register(self::SWAMPLAND_M, new SwamplandMBiome());
        self::register(self::ROOFED_FOREST, new RoofedForestBiome());
        self::register(self::ROOFED_FOREST_M, new RoofedForestMBiome());

        self::register(CustomBiome::VOID, new EmptyBiome());

        // Reverse populators
        foreach (self::$customBiomes as $biome) {
            if ($biome === null) continue;
            $p = $biome->getPopulators();
            $biome->clearPopulators();
            foreach (array_reverse($p) as $pp) {
                $biome->addPopulator($pp);
            }
        }
    }

    protected static function register(int $id, Biome $biome)
    {
        self::$customBiomes[$id] = $biome;
        $biome->setId($id);
    }

    /**
     * @param int $id
     *
     * @return Biome
     */
    public static function getBiome(int $id): Biome
    {
        if (self::$customBiomes[$id] === null) {
            self::register($id, new UnknownBiome());
        }
        return self::$customBiomes[$id];
    }

    public function getBaseHeight(): float
    {
        return $this->baseHeight;
    }

    public function setBaseHeight(float $baseHeight): void
    {
        $this->baseHeight = $baseHeight;
    }

    public function getHeightVariation(): float
    {
        return $this->heightVariation;
    }

    public function setHeightVariation(float $heightVariation): void
    {
        $this->heightVariation = $heightVariation;
    }

    public function doesOverhang(): bool
    {
        return false;
    }

    public function getHeightOffset(int $x, int $z): int
    {
        return 0;
    }

    public function isFreezing(): bool
    {
        return false;
    }

    public function setTemperature(float $temp): void
    {
        $this->temperature = $temp;
    }

    public function setRainfall(float $rainfall): void
    {
        $this->rainfall = $rainfall;
    }

}
