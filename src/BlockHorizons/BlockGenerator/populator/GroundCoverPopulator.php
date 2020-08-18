<?php
namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\biomes\CustomBiome;
use BlockHorizons\BlockGenerator\biomes\type\CoveredBiome;
use BlockHorizons\BlockGenerator\generators\BlockGenerator;
use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\level\ChunkManager;
use pocketmine\level\biome\Biome;
use pocketmine\level\generator\populator\Populator;
use pocketmine\utils\Random;
use pocketmine\level\format\Chunk;


class GroundCoverPopulator extends Populator {

   const STONE = Block::STONE << 4;

    public function populate(ChunkManager $level, int $chunkX, int $chunkZ, Random $random) : void {
        $realX = $chunkX << 4;
        $realZ = $chunkZ << 4;
        $chunk = $level->getChunk($chunkX, $chunkZ);
        for ($x = 0; $x < 16; ++$x) {
            for ($z = 0; $z < 16; ++$z) {
                $biome = CustomBiome::getBiome($chunk->getBiomeId($x, $z));
                if ($biome instanceof CoveredBiome) {
                    $biome->preCover($realX | $x, $realZ | $z);

                    $hasCovered = false;
                    $realY = 0; // int
                    for ($y = 254; $y > 32; $y--) {
                        if ($chunk->getFullBlock($x, $y, $z) === self::STONE) {
                            COVER:
                            if (!$hasCovered) {
                                if ($y >= BlockGenerator::SEA_HEIGHT) {
                                    $coverBlock = self::fromFullBlock($biome->getCoverBlock($y), $chunk);

                                    if($coverBlock->getId() > 0) {
                                        $chunk->setBlock($x, $y + 1, $z, $coverBlock->getId(), $coverBlock->getDamage());
                                    }
                                    $surfaceDepth = $biome->getSurfaceDepth($y);
                                    for ($i = 0; $i < $surfaceDepth; $i++) {
                                        $realY = $y - $i;
                                        $surfaceBlock = self::fromFullBlock($biome->getSurfaceBlock($realY) << 4, $chunk);
                                        if ($chunk->getFullBlock($x, $realY, $z) === self::STONE) {
                                            $chunk->setBlock($x, $realY, $z, $surfaceBlock->getId(), $surfaceBlock->getDamage());
                                        } else {
                                            $y--; goto COVER; // FIXME
                                        };
                                    }
                                    $y -= $surfaceDepth;
                                }
                                $groundDepth = $biome->getGroundDepth($y);
                                for ($i = 0; $i < $groundDepth; $i++) {
                                    $realY = $y - $i;
                                    $groundBlock = self::fromFullBlock($biome->getGroundBlock($realY) << 4, $chunk);
                                    if ($chunk->getFullBlock($x, $realY, $z) === self::STONE) {
                                        $chunk->setBlock($x, $realY, $z, $groundBlock->getId(), $groundBlock->getDamage());
                                    } else {
                                        $y--; goto COVER;
                                    }
                                }
                                    //don't take all of groundDepth away because we do y-- in the loop
                                    $y -= $groundDepth - 1;
                                }
                                $hasCovered = true;
                            } else {
                            if ($hasCovered) {
                                //reset it if this isn't a valid stone block (allows us to place ground cover on top and below overhangs)
                                $hasCovered = false;
                            }
                        }
                    }
                }
            }
        }
    }

    public static function fromFullBlock(int $fullState, Chunk $chunk) : Block{
        return BlockFactory::get($fullState >> 4, $fullState & 0xf);
    }
}
