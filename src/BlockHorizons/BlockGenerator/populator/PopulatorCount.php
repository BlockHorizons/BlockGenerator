<?php
namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\helper\PopulatorHelpers;
use pocketmine\block\BlockFactory;
use pocketmine\level\ChunkManager;
use pocketmine\level\format\Chunk;
use pocketmine\level\generator\populator\Populator;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

abstract class PopulatorCount extends Populator {
	
	protected $randomAmount = 1;
    protected $baseAmount;
    protected $spreadChance = 0;

    public function setRandomAmount(int $randomAmount) : void {
        $this->randomAmount = $randomAmount + 1;
    }

    public function setBaseAmount(int $baseAmount) : void {
        $this->baseAmount = $baseAmount;
    }

    public function setSpreadChance(float $chance) : void {
        $this->spreadChance = $chance;
    }

    protected function spread(int $x, int $y, int $z, ChunkManager $level) : ? Vector3 {
        return null;
    }

    public function populate(ChunkManager $level, int $chunkX, int $chunkZ, Random $random) : void {
        $count = $this->baseAmount + $random->nextBoundedInt($this->randomAmount);
        for ($i = 0; $i < $count; $i++) {
            $this->populateCount($level, $chunkX, $chunkZ, $random);
        }
    }

    protected abstract function populateCount(ChunkManager $level, int $chunkX, int $chunkZ, Random $random) : void;

}