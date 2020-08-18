<?php
namespace BlockHorizons\BlockGenerator\biomes\type;

use BlockHorizons\BlockGenerator\populator\DoublePlantPopulator;
use BlockHorizons\BlockGenerator\populator\FlowerPopulator;
use BlockHorizons\BlockGenerator\populator\GrassPopulator;
use pocketmine\block\Block;
use pocketmine\block\DoublePlant;
use pocketmine\block\Flower;
use pocketmine\level\generator\populator\TallGrass;

abstract class GrassyBiome extends CoveredBiome {

	public function __construct() {
        $grass = new GrassPopulator();
        $grass->setBaseAmount(30);
        $this->addPopulator($grass);

        $tallGrass = new TallGrass();
        $tallGrass->setBaseAmount(30);
        $this->addPopulator($tallGrass);

        $flower = new FlowerPopulator();
        $flower->setBaseAmount(10);
        $flower->addType(Block::DANDELION, 0);
        $flower->addType(Block::RED_FLOWER, Flower::TYPE_POPPY);
        $flower->addType(Block::RED_FLOWER, Flower::TYPE_ALLIUM);
        $flower->addType(Block::DOUBLE_PLANT, 1);
        $flower->addType(Block::DOUBLE_PLANT, 2);
        $flower->addType(Block::DOUBLE_PLANT, 3);
        $this->addPopulator($flower);
    }

    public function getSurfaceBlock(int $y) : int {
        return Block::GRASS;
    }

    public function getGroundBlock(int $y) : int {
        return Block::DIRT;
    }

}