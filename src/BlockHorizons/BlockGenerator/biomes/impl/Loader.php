<?php

namespace BlockHorizons\BlockGenerator;

use BlockHorizons\BlockGenerator\biomes\CustomBiome;
use BlockHorizons\BlockGenerator\biomes\CustomBiomeSelector;
use BlockHorizons\BlockGenerator\generators\BlockGenerator;
use BlockHorizons\BlockGenerator\math\CustomRandom;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\level\generator\GeneratorManager;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase implements Listener {

	private $config;
	
	public function onEnable() {
		CustomBiome::init();

		$b = new CustomBiomeSelector(new CustomRandom());
		$b->recalculate();
		
		GeneratorManager::addGenerator(BlockGenerator::class, "blockgen", true);
		$this->getServer()->generateLevel("rblock", 404, BlockGenerator::class, []);
		$this->getServer()->loadLevel("rblock");
		$level = $this->getServer()->getLevelByName("rblock");

		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function onPlayerMove(PlayerMoveEvent $event) {
		$player = $event->getPlayer();
		$chunk = $player->getLevel()->getChunk($cx = $player->x >> 4, $cz = $player->z >> 4);
		$biome = CustomBiome::getBiome($chunk->getBiomeId($rx = $player->x % 16, $rz = $player->z % 16));
		$player->sendTip("Chunk ($cx, $cz)"."\n"."Biome @ {$rx}, {$rz}: ".$biome->getName()." ({$biome->getId()})"."\n"."Temperature: ".$biome->getTemperature()."\n"."Rainfall: ".$biome->getRainfall()." Elevation: ".$biome->getBaseHeight()." variation: ".$biome->getHeightVariation());
	}
	
	public function onDisable() {
		
	}
}
