<?php

namespace BlockHorizons\BlockGenerator\renderer;

use BlockHorizons\BlockGenerator\biomes\CustomBiomeSelector;
use BlockHorizons\BlockGenerator\math\CustomRandom;

trait Statistics
{

    public function makeStatistics(int $seed, int $radius = 500): void
    {
        $random = new CustomRandom($seed);
        $selector = new CustomBiomeSelector($random);

        $biomeMap = [];
        $found = [];
        $biomeCount = [];
        $total = 0;
        $allBiomes = (new \ReflectionClass(CustomBiome::class))->getConstants();

        $this->getLogger()->info("Creating a statistics file for seed: $seed ...");
        for ($x = -$radius; $x <= $radius; $x++) {
            for ($z = -$radius; $z <= $radius; $z++) {
                $total++;
                $cx = $x * 16;
                $cz = $z * 16;
                $id = $selector->pickBiome($cx, $cz)->getId();
                $biomeMap[$x][$z] = $id;

                if (!isset($biomeCount[$id])) {
                    $biomeCount[$id] = 0;
                }
                $biomeCount[$id]++;

                if (isset($found[$id])) continue;
                $found[$id] = [$cx, $cz];
            }
        }

        $log = "--------- Seed: $seed ------------" . PHP_EOL;
        $log .= "Radius: $radius" . PHP_EOL;
        $log .= "Chunks processed: " . $total . PHP_EOL;
        $log .= "Biomes in total: " . count($allBiomes) . PHP_EOL;
        $log .= "Biomes found: " . count($found) . PHP_EOL;
        $log .= PHP_EOL;
        $log .= " * Statistics:" . PHP_EOL;
        foreach ($allBiomes as $constant => $id) {
            if ($constant === "MAX_BIOMES" || !isset($biomeCount[$id])) continue;

            $p = round(($biomeCount[$id] ?? 0) / $total * 100, 1);
            $log .= "- " . self::pretty_constant($constant) . ": {$p}% (" . (($biomeCount[$id] ?? 0)) . " chunks)" . PHP_EOL;
        }
        $log .= "--------- End of statistics ---------" . PHP_EOL;
        $log .= " * Coords:" . PHP_EOL;
        foreach ($found as $id => $coords) {
            $name = self::pretty_constant(array_search($id, $allBiomes));
            $log .= "- {$name}: X: " . $coords[0] . ", Z: " . $coords[1] . PHP_EOL;
        }
        $log .= "--------- End of Coords ---------" . PHP_EOL;
        $s = "";
        foreach ($allBiomes as $constant => $id) {
            if (isset($found[$id])) continue;
            $s .= self::pretty_constant($constant) . ", ";
        }
        $log .= "Biomes not included: " . (strlen($s) > 0 ? rtrim($s, ", ") : "none") . PHP_EOL;
        $log .= "--------- End of File ---------";

        echo $log;

        file_put_contents($this->getDataFolder() . "seed_{$seed}.txt", $log);
    }

}