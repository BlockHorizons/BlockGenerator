<?php
namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\math\CustomRandom;
use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\level\format\Chunk;
use pocketmine\level\generator\populator\Populator;
use pocketmine\utils\Random;

class RavinesPopulator extends Populator {

    protected static $replaceable = [
        Block::GRASS => true,
        Block::DIRT => true,
        Block::STONE => true,
        Block::IRON_ORE => true,
        Block::COAL_ORE => true,
        Block::DIAMOND_ORE => true,
        Block::LAPIS_ORE => true,
        Block::GOLD_ORE => true,
        Block::EMERALD_ORE => true,
        Block::GRAVEL => true
    ];

    protected $checkAreaSize = 8;

    protected $random;
    protected $worldLong1;
    protected $worldLong2;

    protected $ravineRarity = 2;
    protected $ravineMinAltitude = 20;
    protected $ravineMaxAltitude = 70;
    protected $ravineMinLength = 84;
    protected $ravineMaxLength = 111;

    protected $ravineDepth = 20;

    protected $worldHeightCap = 1 << 8;

    protected $a = []; // 1024

    public function populate(ChunkManager $level, int $chunkX, int $chunkZ, Random $random) : void {
        $this->random = new CustomRandom();
        $this->random->setSeed($level->getSeed());
        $worldLong1 = $this->random->nextLong();
        $worldLong2 = $this->random->nextLong();

        $i = $this->checkAreaSize;

        for ($x = $chunkX - $i; $x <= $chunkX + $i; $x++)
            for ($z = $chunkZ - $i; $z <= $chunkZ + $i; $z++) {
                $l3 = $x * $worldLong1;
                $l4 = $z * $worldLong2;
                $this->random->setSeed($l3 ^ $l4 ^ $level->getSeed());
                $this->generateChunk($chunkX, $chunkZ, $level->getChunk($chunkX, $chunkZ));
            }
    }

    protected function generateChunk(int $chunkX, int $chunkZ, Chunk $generatingChunkBuffer) : void {
        if ($this->random->nextBoundedInt(300) >= $this->ravineRarity) return;
        $d1 = ($chunkX * 16) + $this->random->nextBoundedInt(16);
        $d2 = self::numberInRange($this->random, $this->ravineMinAltitude, $this->ravineMaxAltitude);
        $d3 = ($chunkZ * 16) + $this->random->nextBoundedInt(16);

        $i = 1;

        for ($j = 0; $j < $i; $j++) {
            $f1 = $this->random->nextFloat() * 3.141593 * 2.0;
            $f2 = ($this->random->nextFloat() - 0.5) * 2.0 / 8.0;
            $f3 = ($this->random->nextFloat() * 2.0 + $this->random->nextFloat()) * 2.0;

            $size = self::numberInRange($this->random, $this->ravineMinLength, $this->ravineMaxLength);

            $this->createRavine($this->random->nextLong(), $generatingChunkBuffer, $d1, $d2, $d3, $f3, $f1, $f2, $size, $this->ravineDepth);
        }
    }

    protected function createRavine(int $paramLong, Chunk $generatingChunkBuffer, float $paramDouble1,  float $paramDouble2, float $paramDouble3, float $paramFloat1, float $paramFloat2, float $paramFloat3, int $size, float $paramDouble4) {
        $localRandom = new CustomRandom($paramLong);

        $chunkX = $generatingChunkBuffer->getX();
        $chunkZ = $generatingChunkBuffer->getZ();

        $d1 = $chunkX * 16 + 8;
        $d2 = $chunkZ * 16 + 8;

        $f1 = 0.0;
        $f2 = 0.0;

        $i = 0;

        $f3 = 1.0;
        for ($j = 0; ; $j++) {
            if($j >= $this->worldHeightCap) break;
            if (($j === 0) || ($localRandom->nextBoundedInt(3) === 0)) {
                $f3 = 1.0 + $localRandom->nextFloat() * $localRandom->nextFloat() * 1.0;
            }
            $this->a[$j] = ($f3 * $f3);
        }

        for ($stepCount = 0; $stepCount < $size; $stepCount++) {
            $d3 = 1.5 + sin($stepCount * 3.141593 / $size) * $paramFloat1 * 1.0;
            $d4 = $d3 * $paramDouble4;

            $d3 *= ($localRandom->nextFloat() * 0.25 + 0.75);
            $d4 *= ($localRandom->nextFloat() * 0.25 + 0.75);

            $f4 = cos($paramFloat3);
            $f5 = sin($paramFloat3);
            $paramDouble1 += cos($paramFloat2) * $f4;
            $paramDouble2 += $f5;
        $paramDouble3 += sin($paramFloat2) * $f4;

            $paramFloat3 *= 0.7;

            $paramFloat3 += $f2 * 0.05;
            $paramFloat2 += $f1 * 0.05;

            $f2 *= 0.8;
            $f1 *= 0.5;
            $f2 += ($localRandom->nextFloat() - $localRandom->nextFloat()) * $localRandom->nextFloat() * 2.0;
            $f1 += ($localRandom->nextFloat() - $localRandom->nextFloat()) * $localRandom->nextFloat() * 4.0;

            if (($i === 0) && ($localRandom->nextBoundedInt(4) === 0)) {
                continue;
            }
            $d5 = $paramDouble1 - $d1;
            $d6 = $paramDouble3 - $d2;
            $d7 = $size - $stepCount;
            $d8 = $paramFloat1 + 2.0 + 16.0;
            if ($d5 * $d5 + $d6 * $d6 - $d7 * $d7 > $d8 * $d8) {
                return;
            }

            if (($paramDouble1 < $d1 - 16.0 - $d3 * 2.0) || ($paramDouble3 < $d2 - 16.0 - $d3 * 2.0) || ($paramDouble1 > $d1 + 16.0 + $d3 * 2.0) || ($paramDouble3 > $d2 + 16.0 + $d3 * 2.0))
                continue;
            $k = floor($paramDouble1 - $d3) - ($chunkX * 16) - 1;
            $m = floor($paramDouble1 + $d3) - ($chunkZ * 16) + 1;

            $maxY = floor($paramDouble2 - $d4) - 1;
            $minY = floor($paramDouble2 + $d4) + 1;

            $i2 = floor($paramDouble3 - $d3) - ($chunkX * 16) - 1;
            $i3 = floor($paramDouble3 + $d3) - ($chunkZ * 16) + 1;

            if ($k < 0)
                $k = 0;
            if ($m > 16)
                $m = 16;

            if ($maxY < 1)
                $maxY = 1;
            if ($minY > $this->worldHeightCap - 8)
                $minY = $this->worldHeightCap - 8;

            if ($i2 < 0)
                $i2 = 0;
            if ($i3 > 16)
                $i3 = 16;

            $i4 = 0;
            for ($localX = $k; ($i4 == 0) && ($localX < $m); $localX++) {
                for ($localZ = $i2; ($i4 == 0) && ($localZ < $i3); $localZ++) {
                    for ($localY = $minY + 1; ($i4 == 0) && ($localY >= $maxY - 1); $localY--) {
                        if ($localY < 0)
                            continue;
                        if ($localY < $this->worldHeightCap) {
                            $materialAtPosition = $generatingChunkBuffer->getBlockId($localX, $localY, $localZ);
                            if ($materialAtPosition === Block::WATER
                                    || $materialAtPosition === Block::STILL_WATER) {
                                $i4 = 1;
                            }
                            if (($localY != $maxY - 1) && ($localX != $k) && ($localX != $m - 1) && ($localZ != $i2) && ($localZ != $i3 - 1))
                                $localY = $maxY;
                        }
                    }
                }
            }
            if ($i4 != 0) {
                continue;
            }
            for ($localX = $k; $localX < $m; $localX++) {
                $d9 = ($localX + ($chunkX * 16) + 0.5 - $paramDouble1) / $d3;
                for ($localZ = $i2; $localZ < $i3; $localZ++) {
                    $d10 = ($localZ + ($chunkZ * 16) + 0.5 - $paramDouble3) / $d3;
                    if ($d9 * $d9 + $d10 * $d10 < 1.0) {
                        for ($localY = $minY; $localY >= $maxY; $localY--) {
                            $d11 = (($localY - 1) + 0.5 - $paramDouble2) / $d4;
                            if (($d9 * $d9 + $d10 * $d10) * $this->a[$localY - 1] + $d11 * $d11 / 6.0 < 1.0) {
                                $material = $generatingChunkBuffer->getBlockId($localX, $localY, $localZ);
                                if (self::canBeReplaced($material)) {
                                    if ($localY - 1 < 10) {
                                        $generatingChunkBuffer->setBlock($localX, $localY, $localZ, Block::LAVA);
                                    } else {
                                        $generatingChunkBuffer->setBlock($localX, $localY, $localZ, Block::AIR);
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if ($i != 0)
                break;
        }
    }

    public static function canBeReplaced(int $id) : bool {
        return isset(self::$replaceable[$id]);
    }

    public static function numberInRange(Random $random, int $min, int $max) : int {
        return $min + $random->nextBoundedInt($max - $min + 1);
    }
}