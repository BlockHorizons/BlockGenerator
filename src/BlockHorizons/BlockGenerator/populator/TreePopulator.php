<?php
namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\object\AcaciaTree;
use BlockHorizons\BlockGenerator\object\BigSpruceTree;
use pocketmine\block\Block;

use pocketmine\level\ChunkManager;
use pocketmine\level\generator\object\BirchTree;
use pocketmine\level\generator\object\JungleTree;
use pocketmine\level\generator\object\OakTree;
use pocketmine\level\generator\object\SpruceTree;
use pocketmine\level\generator\object\Tree;
use pocketmine\utils\Random;

class TreePopulator extends PopulatorCount {
	
    private $type;
    private $super;
    private $level;

    public function __construct(int $type = \pocketmine\block\Wood::OAK, bool $super = false) {
        $this->type = $type;
        $this->super = $super;
    }

    public function populateCount(ChunkManager $level, int $chunkX, int $chunkZ, Random $random) : void {
        $this->level = $level;
        $x = $random->nextRange($chunkX << 4, ($chunkX << 4) + 15);
        $z = $random->nextRange($chunkZ << 4, ($chunkZ << 4) + 15);
        $y = $this->getHighestWorkableBlock($x, $z);
        if ($y < 3) {
            return;
        }

        switch($this->type){
            case \pocketmine\block\Wood::SPRUCE:
                if($this->super) {
                    $tree = new BigSpruceTree(); // TODO: does normal API ?
                } else {
                    $tree = new SpruceTree();
                }
                break;
            case \pocketmine\block\Wood::BIRCH:
                $tree = new BirchTree($this->super);
                break;
            case \pocketmine\block\Wood::JUNGLE:
                $tree = new JungleTree();
                break;
            case \pocketmine\block\Wood2::ACACIA:
                $tree = new AcaciaTree();
                break;
            case \pocketmine\block\Wood2::DARK_OAK:
                return; //TODO
            default:
                $tree = new OakTree();
                /*if($random->nextRange(0, 9) === 0){
                    $tree = new BigTree();
                }else{*/

                //}
                break;
        }
        if($tree->canPlaceObject($level, $x, $y, $z, $random)){
            $tree->placeObject($level, $x, $y, $z, $random);
        }
    }

    private function getHighestWorkableBlock(int $x, int $z) : int {
        for ($y = 254; $y > 0; --$y) {
            $b = $this->level->getBlockIdAt($x, $y, $z);
            if ($b === Block::DIRT || $b === Block::GRASS || $b === Block::TALL_GRASS) {
                break;
            } elseif ($b !== Block::AIR && $b !== Block::SNOW_LAYER) {
                return -1;
            }
        }

        return ++$y;
    }

}