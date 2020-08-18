<?php
namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\populator\SurfaceBlockPopulator;
use BlockHorizons\BlockGenerator\populator\helper\EnsureCover;
use BlockHorizons\BlockGenerator\populator\helper\EnsureGrassBelow;
use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\level\format\Chunk;
use pocketmine\utils\Random;

class FlowerPopulator extends SurfaceBlockPopulator {

    protected $flowerTypes = [];

    public function addType(int $a, int $b) {
        $c = [];
        $c[0] = $a;
        $c[1] = $b;
        $this->flowerTypes[] = $c;
    }

    public function getTypes() : array {
        return $this->flowerTypes;
    }

    protected function placeBlock(int $x, int $y, int $z, int $id, Chunk $chunk, Random $random) : void {
        if (count($this->flowerTypes) !== 0) {
            $type = $this->flowerTypes[$random->nextRange(0, count($this->flowerTypes) -1)];

            $b = BlockFactory::get($type[0], $type[1]);
            $chunk->setBlockId($x, $y, $z, $b->getId());
            $chunk->setBlockData($x, $y, $z, $b->getVariant());
            if ($type[0] === Block::DOUBLE_PLANT) {
                $chunk->setBlock($x, $y + 1, $z, $b->getId(), $b->getVariant() | 0x08);
            }
        }
    }

    protected function canStay(int $x, int $y, int $z, Chunk $chunk) : bool {
        return EnsureCover::ensureCover($x, $y, $z, $chunk) && EnsureGrassBelow::ensureGrassBelow($x, $y, $z, $chunk);
    }

    protected function getBlockId(int $x, int $z, Random $random, Chunk $chunk) : int {
        return 0;
    }
}
