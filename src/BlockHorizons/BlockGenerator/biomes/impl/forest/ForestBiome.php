<?php
namespace BlockHorizons\BlockGenerator\biomes\impl\forest;

use BlockHorizons\BlockGenerator\biomes\type\GrassyBiome;
use BlockHorizons\BlockGenerator\populator\TreePopulator;

use pocketmine\block\Block;


class ForestBiome extends GrassyBiome {

    const TYPE_NORMAL = 0;
    const TYPE_BIRCH = 1;
    const TYPE_BIRCH_TALL = 2;

    protected $type;

    public function __construct(int $type = self::TYPE_NORMAL) {

        $this->type = $type;

        $trees = new TreePopulator($type === self::TYPE_NORMAL ? \pocketmine\block\Wood::OAK : \pocketmine\block\Wood::BIRCH, $type === self::TYPE_BIRCH_TALL ? true : false);
        $trees->setBaseAmount($type === self::TYPE_NORMAL ? 3 : 6);
        $this->addPopulator($trees);

        if ($type == self::TYPE_NORMAL) {
            //normal forest biomes have both oak and birch trees
            $trees = new TreePopulator(\pocketmine\block\Wood::OAK);
            $trees->setBaseAmount(3);
            $this->addPopulator($trees);
        }
    }

    public function getType() : int {
        return $this->type;
    }

    public function getName() : string {
        switch ($this->type) {
            case self::TYPE_BIRCH:
                return "Birch Forest";
            case self::TYPE_BIRCH_TALL:
                return "Birch Forest M";
            default:
                return "Forest";
        }
    }
}
