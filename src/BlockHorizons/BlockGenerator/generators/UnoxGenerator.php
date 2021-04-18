<?php

namespace BlockHorizons\BlockGenerator\generators;

use BlockHorizons\BlockGenerator\biomes\CustomBiome;
use BlockHorizons\BlockGenerator\biomes\CustomBiomeSelector;
use BlockHorizons\BlockGenerator\math\CustomRandom;
use BlockHorizons\BlockGenerator\math\MathHelper;
use BlockHorizons\BlockGenerator\noise\NoiseGeneratorOctaves;
use BlockHorizons\BlockGenerator\populator\BedrockPopulator;
use BlockHorizons\BlockGenerator\populator\CavePopulator;
use BlockHorizons\BlockGenerator\populator\GroundCoverPopulator;
use pocketmine\block\Block;
use pocketmine\block\BlockIds;
use pocketmine\block\Stone;
use pocketmine\level\generator\biome\BiomeSelector;
use pocketmine\level\generator\object\OreType;
use pocketmine\level\generator\populator\Ore;
use pocketmine\math\Vector3;

/**
 * BlockGenerator is improved default generator
 */
class UnoxGenerator extends CustomGenerator
{

    public $selector;

    public function __construct(array $options = [])
    {
        parent::__construct($options);
    }

    public function generateChunk(int $chunkX, int $chunkZ): void
    {
        $baseX = $chunkX << 4;
        $baseZ = $chunkZ << 4;

        $chunk = $this->level->getChunk($chunkX, $chunkZ);

        for($x = 0; $x < 16; $x++) {
            for($z = 0; $z < 16; $z++) {
                $chunk->setBlockId($baseX + $x, 32, $baseZ + $z, BlockIds::STONE);
            }
        }
    }

    public function populateChunk(int $chunkX, int $chunkZ): void
    {
        // Unnecessary for now
    }

    public function getName(): string
    {
        return "UnoxGenerator";
    }

    public function getSpawn(): Vector3
    {
        return new Vector3(0.5, 256, 0.5);
    }

    public function getSelector(): CustomBiomeSelector
    {
        return $this->selector;
    }

}
	