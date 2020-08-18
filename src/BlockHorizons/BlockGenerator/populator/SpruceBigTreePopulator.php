<?php
namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\object\BigSpruceTree;
use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\level\generator\populator\Populator;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

class SpruceBigTreePopulator extends Populator {

    private $level;
    private $randomAmount;
    private $baseAmount;

    public function setRandomAmount(int $randomAmount) : void {
        $this->randomAmount = $randomAmount;
    }

    public function setBaseAmount(int $baseAmount) : void {
        $this->baseAmount = $baseAmount;
    }

    public function populate(ChunkManager $level, int $chunkX, int $chunkZ, Random $random) : void {
        $this->level = $level;
        $amount = $random->nextBoundedInt($this->randomAmount + 1) + $this->baseAmount;
        $v = new Vector3();

        for ($i = 0; $i < $amount; ++$i) {
            $x = $random->nextBoundedInt($chunkX << 4, ($chunkX << 4) + 15);
            $z = $random->nextBoundedInt($chunkZ << 4, ($chunkZ << 4) + 15);
            $y = $this->getHighestWorkableBlock($x, $z);
            if ($y == -1) {
                continue;
            }
            (new BigSpruceTree(3 / 4, 4))->placeObject($this->level, (int) ($v->x = $x), (int) ($v->y = $y), (int) ($v->z = $z), $random);
        }
    }

    private function getHighestWorkableBlock(int $x, int $z) : int {
        $y = 0;
        for ($y = 255; $y > 0; --$y) {
            $b = $this->level->getBlockIdAt($x, $y, $z);
            if ($b === Block::DIRT || $b === Block::GRASS) {
                break;
            } elseif ($b != Block::AIR && $b != Block::SNOW_LAYER) {
                return -1;
            }
        }

        return ++$y;
    }

}
