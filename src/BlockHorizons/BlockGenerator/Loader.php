<?php

namespace BlockHorizons\BlockGenerator;

use BlockHorizons\BlockGenerator\biomes\CustomBiome;
use BlockHorizons\BlockGenerator\biomes\CustomBiomeSelector;
use BlockHorizons\BlockGenerator\generators\BlockGenerator;
use BlockHorizons\BlockGenerator\map\BiomeMapGenerator;
use BlockHorizons\BlockGenerator\math\CustomRandom;
use BlockHorizons\BlockGenerator\math\FacingHelper;
use BlockHorizons\BlockGenerator\noise\PerlinF;
use BlockHorizons\BlockGenerator\noise\SimplexF;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\level\generator\GeneratorManager;
use pocketmine\math\Vector2;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase implements Listener
{

    private $config;

    public function onLoad()
    {
        CustomBiome::init();

        $b = new CustomBiomeSelector($r = new CustomRandom());
        $b->recalculate();

        @rmdir("worlds/rblock");
        GeneratorManager::addGenerator(BlockGenerator::class, "blockgen", true);
        $this->getServer()->generateLevel("rblock", 1338, BlockGenerator::class, []);
        $this->getServer()->loadLevel("rblock");
        $level = $this->getServer()->getLevelByName("rblock");
    }

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);

//         $this->makeMap(1338, 100);
//         $this->makeStatistics(1338, 100);
    }

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

    public function makeMap(int $seed, int $radius = 500): void
    {
        make_map:

        $random = new CustomRandom($seed);
        $selector = new CustomBiomeSelector($random);

        $maker = new BiomeMapGenerator($selector);
        $map = $maker->createMap(new Vector2(0, 0), $radius, 16);

        if (extension_loaded("gd")) {
            $image = $maker->createImageFromMap($map);

            if ($image) {
                $fileName = $seed.mt_rand(0, 100).".jpg";
				imagejpeg($image, $this->getDataFolder().$fileName);
				$this->getLogger()->notice("Image of the map saved(Seed: $seed)!");
			} else {
				$this->getLogger()->error("Failed to save map");
			}
		} else {
			$this->getLogger()->error("Can not create image, gd extension not found!");
		}
		//goto make_map;
	}

	public function onPlayerMove(PlayerMoveEvent $event) {
		$player = $event->getPlayer();
		$chunk = $player->getLevel()->getChunk($cx = $player->x >> 4, $cz = $player->z >> 4);
		$biome = CustomBiome::getBiome($chunk->getBiomeId($rx = $player->x % 16, $rz = $player->z % 16));
		$player->sendTip("Chunk($cx, $cz)"."\n"."Biome @ {$rx}, {$rz}: ".$biome->getName()." ({$biome->getId()})"."\n"."Temperature: ".$biome->getTemperature()."\n"."Rainfall: ".$biome->getRainfall()." Elevation: ".$biome->getBaseHeight()." variation: ".$biome->getHeightVariation());
	}
	
	public function onDisable() {
		
	}

	public static function pretty_constant(string $s) : string {
		$p = explode("_", $s);
		$r = "";
		foreach($p as $pp) {
			$r .= ucfirst(strtolower($pp))." ";
		}
		return trim($r);
	}

}
