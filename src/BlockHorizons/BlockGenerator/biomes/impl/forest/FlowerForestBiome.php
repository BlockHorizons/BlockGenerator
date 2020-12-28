<?php

namespace BlockHorizons\BlockGenerator\biomes\impl\forest;

use BlockHorizons\BlockGenerator\populator\FlowerPopulator;
use pocketmine\block\Block;
use pocketmine\block\Flower;

class FlowerForestBiome extends ForestBiome
{

    public function __construct(int $type = ForestBiome::TYPE_NORMAL)
    {
        parent::__construct($type);

        //see https://minecraft.gamepedia.com/Flower#Flower_biomes
        $flower = new FlowerPopulator();
        $flower->setBaseAmount(10);
        $flower->addType(Block::DANDELION, 0);
        $flower->addType(Block::RED_FLOWER, Flower::TYPE_POPPY);
        $flower->addType(Block::RED_FLOWER, Flower::TYPE_ALLIUM);
        $flower->addType(Block::RED_FLOWER, Flower::TYPE_AZURE_BLUET);
        $flower->addType(Block::RED_FLOWER, Flower::TYPE_RED_TULIP);
        $flower->addType(Block::RED_FLOWER, Flower::TYPE_ORANGE_TULIP);
        $flower->addType(Block::RED_FLOWER, Flower::TYPE_WHITE_TULIP);
        $flower->addType(Block::RED_FLOWER, Flower::TYPE_PINK_TULIP);
        $flower->addType(Block::RED_FLOWER, Flower::TYPE_OXEYE_DAISY);
        $flower->addType(Block::DOUBLE_PLANT, 1);
        $flower->addType(Block::DOUBLE_PLANT, 2);
        $flower->addType(Block::DOUBLE_PLANT, 3);
        $this->addPopulator($flower);

        $this->setHeightVariation(0.4);
    }

    public function getName(): string
    {
        return $this->type == self::TYPE_BIRCH ? "Birch Forest" : "Forest";
    }

}
