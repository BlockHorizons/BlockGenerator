<?php

namespace BlockHorizons\BlockGenerator\map;

use BlockHorizons\BlockGenerator\biomes\CustomBiome;
use pocketmine\level\generator\biome\BiomeSelector;
use pocketmine\math\Vector2;

class BiomeMapGenerator
{

    public static $colors = [
        CustomBiome::RIVER => [50, 50, 255],
        CustomBiome::OCEAN => [0, 0, 255],
        CustomBiome::PLAINS => [50, 255, 50],
        CustomBiome::EXTREME_HILLS => [50, 255, 80],
        CustomBiome::DESERT => [200, 200, 0],
        CustomBiome::FOREST => null,
        CustomBiome::TAIGA => [40, 240, 60],
        CustomBiome::SWAMP => [50, 100, 0],
        CustomBiome::HELL => [255, 0, 0],
        CustomBiome::END => [190, 200, 140],
        CustomBiome::FROZEN_OCEAN => [0, 180, 200], //DOES NOT GENERATE NATUALLY
        CustomBiome::FROZEN_RIVER => [0, 200, 220],
        CustomBiome::ICE_PLAINS => [20, 220, 240],
        CustomBiome::MUSHROOM_ISLAND => null,//
        CustomBiome::MUSHROOM_ISLAND_SHORE => null,
        CustomBiome::BEACH => [200, 200, 10],
        CustomBiome::DESERT_HILLS => [170, 170, 20],
        CustomBiome::FOREST_HILLS => [20, 230, 20],
        CustomBiome::TAIGA_HILLS => [20, 230, 60],
        CustomBiome::EXTREME_HILLS_EDGE => [40, 250, 80], //DOES NOT GENERATE NATUALLY
        CustomBiome::JUNGLE => [0, 150, 0],
        CustomBiome::JUNGLE_HILLS => [0, 200, 0],
        CustomBiome::JUNGLE_EDGE => [0, 130, 0],
        CustomBiome::DEEP_OCEAN => [0, 0, 150],
        CustomBiome::STONE_BEACH => [140, 140, 140],
        CustomBiome::COLD_BEACH => [140, 140, 210],
        CustomBiome::BIRCH_FOREST => [150, 255, 150],
        CustomBiome::BIRCH_FOREST_HILLS => [150, 255, 200],
        CustomBiome::ROOFED_FOREST => null,
        CustomBiome::COLD_TAIGA => [220, 220, 220],
        CustomBiome::COLD_TAIGA_HILLS => null,
        CustomBiome::MEGA_TAIGA => null,
        CustomBiome::MEGA_TAIGA_HILLS => null,
        CustomBiome::EXTREME_HILLS_PLUS => null,
        CustomBiome::SAVANNA => [230, 200, 10],
        CustomBiome::SAVANNA_PLATEAU => [230, 200, 30],
        CustomBiome::MESA => [200, 40, 40],
        CustomBiome::MESA_PLATEAU_F => [200, 40, 80],
        CustomBiome::MESA_PLATEAU => [200, 40, 60],
        CustomBiome::SUNFLOWER_PLAINS => [255, 180, 180],
        CustomBiome::DESERT_M => [255, 255, 80],
        CustomBiome::EXTREME_HILLS_M => null,
        CustomBiome::FLOWER_FOREST => null,
        CustomBiome::TAIGA_M => null,
        CustomBiome::SWAMPLAND_M => null,
        CustomBiome::ICE_PLAINS_SPIKES => null,
        CustomBiome::JUNGLE_M => null,
        CustomBiome::JUNGLE_EDGE_M => null,
        CustomBiome::BIRCH_FOREST_M => null,
        CustomBiome::BIRCH_FOREST_HILLS_M => null,
        CustomBiome::ROOFED_FOREST_M => null,
        CustomBiome::COLD_TAIGA_M => null,
        CustomBiome::MEGA_SPRUCE_TAIGA => null,
        CustomBiome::EXTREME_HILLS_PLUS_M => null,
        CustomBiome::SAVANNA_M => null,
        CustomBiome::SAVANNA_PLATEAU_M => null,
        CustomBiome::MESA_BRYCE => null,
        CustomBiome::MESA_PLATEAU_F_M => null,
        CustomBiome::MESA_PLATEAU_M => null,
        CustomBiome::VOID => null,
    ];
    /** @var Generator */
    protected $selector;

    public function __construct(BiomeSelector $selector)
    {
        $this->selector = $selector;
    }

    public static function saveMap(array $data, string $file): void
    {
        file_put_contents($file, json_encode($data));
    }

    public static function readMap(string $file): array
    {
        return json_decode(file_get_contents($file));
    }

    public function createMap(Vector2 $start, int $radius, int $step = 1): array
    {
        $map = [];
        for ($x = $start->x - $radius * $step; $x < $start->x + $radius * $step; $x += $step) {
            for ($z = $start->y - $radius * $step; $z < $start->y + $radius * $step; $z += $step) {
                $map[$x / $step][$z / $step] = $this->getPixel($x, $z);
            }
        }
        return $map;
    }

    public function getPixel(int $x, int $z): int
    {
        return self::rgbaToInt($this->getBiomeColor($this->getSelector()->pickBiome($x, $z)->getId()));
    }

    public static function rgbaToInt(array $rgba): int
    {
        $color = 0;
        $color |= ($rgba[3] ?? 0 & 255) << 24;
        $color |= ($rgba[0] & 255) << 16;
        $color |= ($rgba[1] & 255) << 8;
        $color |= ($rgba[2] & 255);
        return $color;
    }

    public static function getBiomeColor(int $id): array
    {
        return self::$colors[$id] ?? self::randomColor();
    }

    public static function randomColor(): array
    {
        return [
            mt_rand(50, 250),
            mt_rand(50, 250),
            mt_rand(50, 250),
        ];
    }

    public function getSelector(): BiomeSelector
    {
        return $this->selector;
    }

    public function createImageFromMap(array $map)
    {
        if (empty($map) || !isset($map[0])) return null;

        $sizeX = count($map);
        $sizeZ = count($map[0]);
        $img = imagecreate($sizeX, $sizeZ);

        $half = (int)$sizeX / 2;

        $colors = [];
        foreach ($map as $x => $row) {
            foreach ($row as $z => $color) {
                if (isset($colors[$color])) {
                    $color = $colors[$color];
                } else {
                    $rgba = self::intToRgba($color);
                    $tc = $color;
                    $color = imagecolorallocate($img, $rgba[1], $rgba[2], $rgba[3]);
                    $colors[$tc] = $color;
                }
                imagesetpixel($img, $x + $half, $z + $half, $color);
            }
        }

        return $img;
    }

    public static function intToRgba(int $color): array
    {
        return [
            $color >> 24 & 0xFF,
            $color >> 16 & 0xFF,
            $color >> 8 & 0xFF,
            $color & 0xFF
        ];
    }

}