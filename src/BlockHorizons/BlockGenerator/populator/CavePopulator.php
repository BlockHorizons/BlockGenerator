<?php
namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\biomes\CustomBiome;
use BlockHorizons\BlockGenerator\biomes\type\CoveredBiome;
use BlockHorizons\BlockGenerator\math\CustomRandom;
use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\level\format\Chunk;
use pocketmine\level\generator\populator\Populator;
use pocketmine\utils\Random;

class CavePopulator extends Populator {

    protected $checkAreaSize = 8;

    private $random;

    public static $caveRarity = 99;//7
    public static $caveFrequency = 80;//40
    public static $caveMinAltitude = 8;
    public static $caveMaxAltitude = 67;
    public static $individualCaveRarity = 1;//25
    public static $caveSystemFrequency = 1;
    public static $caveSystemPocketChance = 0;
    public static $caveSystemPocketMinSize = 0;
    public static $caveSystemPocketMaxSize = 4;
    public static $evenCaveDistribution = false;

    public $worldHeightCap = 128;

    protected $worldLong1, $worldLong2;

    public function __construct(Random $random) {
        $worldLong1 = $random->nextLong();
        $worldLong2 = $random->nextLong();
    }

    public function populate(ChunkManager $level, int $chunkX, int $chunkZ, Random $random) : void {
        $this->random = new CustomRandom($random->getSeed());

        $chunk = $level->getChunk($chunkX, $chunkZ);

        $size = $this->checkAreaSize;

        for ($x = $chunkX - $size; $x <= $chunkX + $size; $x++) {
            for ($z = $chunkZ - $size; $z <= $chunkZ + $size; $z++) {
                $this->random->setSeed($chunkX * $this->worldLong1 ^ $chunkZ * $this->worldLong2 ^ $random->getSeed());
                $this->generateChunk($x, $z, $chunk);
            }
        }
    }

    protected function generateLargeCaveNode($seed, Chunk $chunk, float $x, float $y, float $z) : void {
        $this->generateCaveNode($seed, $chunk, $x, $y, $z, 1.0 + $this->random->nextFloat() * 6.0, 0.0, 0.0, -1, -1, 0.5);
    }

    protected function generateCaveNode($seed, Chunk $chunk, float $x, float $y, float $z, float $radius, float $angelOffset, float $angel, int $angle, int $maxAngle, float $scale) : void {
        $chunkX = $chunk->getX();
        $chunkZ = $chunk->getZ();

        $realX = $chunkX * 16 + 8;
        $realZ = $chunkZ * 16 + 8;

        $f1 = 0.0;
        $f2 = 0.0;

        $localRandom = new CustomRandom($seed);

        if ($maxAngle <= 0) {
            $checkAreaSize = $this->checkAreaSize * 16 - 16;
            $maxAngle = $checkAreaSize - $localRandom->nextBoundedInt($checkAreaSize / 4);
        }
        $isLargeCave = false;

        if ($angle == -1) {
            $angle = $maxAngle / 2;
            $isLargeCave = true;
        }

        $randomAngel = $localRandom->nextBoundedInt($maxAngle / 2) + $maxAngle / 4;
        $bigAngel = $localRandom->nextBoundedInt(6) == 0;

        for ($angle = $angle; $angle < $maxAngle; $angle++) {
            $offsetXZ = 1.5 + sin($angle * 3.141593 / $maxAngle) * $radius * 1.0;
            $offsetY = $offsetXZ * $scale;

            $cos = cos($angel);
            $sin = sin($angel);
            $x += cos($angelOffset) * $cos;
            $y += $sin;
            $z += sin($angelOffset) * $cos;

            if ($bigAngel)
                $angel *= 0.92;
            else {
                $angel *= 0.7;
            }
            $angel += $f2 * 0.1;
            $angelOffset += $f1 * 0.1;

            $f2 *= 0.9;
            $f1 *= 0.75;
            $f2 += ($localRandom->nextFloat() - $localRandom->nextFloat()) * $localRandom->nextFloat() * 2.0;
            $f1 += ($localRandom->nextFloat() - $localRandom->nextFloat()) * $localRandom->nextFloat() * 4.0;


            if ((!$isLargeCave) && ($angle == $randomAngel) && ($radius > 1.0) && ($maxAngle > 0)) {
                $this->generateCaveNode($localRandom->nextLong(), $chunk, $x, $y, $z, $localRandom->nextFloat() * 0.5 + 0.5, $angelOffset - 1.570796, $angel / 3.0, $angle, $maxAngle, 1.0);
                $this->generateCaveNode($localRandom->nextLong(), $chunk, $x, $y, $z, $localRandom->nextFloat() * 0.5 + 0.5, $angelOffset + 1.570796, $angel / 3.0, $angle, $maxAngle, 1.0);
                return;
            }
            $ln = $localRandom->nextBoundedInt(4);
            if ((!$isLargeCave) && ($ln == 0)) {
                continue;
            } else {
            }

            // Check if distance to working point (x and z) too larger than working radius (maybe ??)
            $distanceX = $x - $realX;
            $distanceZ = $z - $realZ;
            $angelDiff = $maxAngle - $angle;
            $newRadius = $radius + 2.0 + 16.0;
            if ($distanceX * $distanceX + $distanceZ * $distanceZ - $angelDiff * $angelDiff > $newRadius * $newRadius) {
                return;
            }

            //Boundaries check.
            if (($x < $realX - 16.0 - $offsetXZ * 2.0) || ($z < $realZ - 16.0 - $offsetXZ * 2.0) || ($x > $realX + 16.0 + $offsetXZ * 2.0) || ($z > $realZ + 16.0 + $offsetXZ * 2.0)) {
                continue;
            }

            $xFrom = floor($x - $offsetXZ) - $chunkX * 16 - 1;
            $xTo = floor($x + $offsetXZ) - $chunkX * 16 + 1;

            $yFrom = floor($y - $offsetY) - 1;
            $yTo = floor($y + $offsetY) + 1;

            $zFrom = floor($z - $offsetXZ) - $chunkZ * 16 - 1;
            $zTo = floor($z + $offsetXZ) - $chunkZ * 16 + 1;

            if ($xFrom < 0)
                $xFrom = 0;
            if ($xTo > 16)
                $xTo = 16;

            if ($yFrom < 1)
                $yFrom = 1;
            if ($yTo > $this->worldHeightCap - 8) {
                $yTo = $this->worldHeightCap - 8;
            }
            if ($zFrom < 0)
                $zFrom = 0;
            if ($zTo > 16)
                $zTo = 16;

            // Search for water
            $waterFound = false;
            for ($xx = $xFrom; (!$waterFound) && ($xx < $xTo); $xx++) {
                for ($zz = $zFrom; (!$waterFound) && ($zz < $zTo); $zz++) {
                    for ($yy = $yTo + 1; (!$waterFound) && ($yy >= $yFrom - 1); $yy--) {
                        if ($yy >= 0 && $yy < $this->worldHeightCap) {
                            $block = $chunk->getBlockId($xx, $yy, $zz);
                            if ($block == Block::WATER || $block == Block::STILL_WATER) {
                                $waterFound = true;
                            }
                            if (($yy != $yFrom - 1) && ($xx != $xFrom) && ($xx != $xTo - 1) && ($zz != $zFrom) && ($zz != $zTo - 1))
                                $yy = $yFrom;
                        }
                    }
                }
            }

            if ($waterFound) {
                continue;
            }

            // Generate cave
            for ($xx = $xFrom; $xx < $xTo; $xx++) {
                $modX = ($xx + $chunkX * 16 + 0.5 - $x) / $offsetXZ;
                for ($zz = $zFrom; $zz < $zTo; $zz++) {
                    $modZ = ($zz + $chunkZ * 16 + 0.5 - $z) / $offsetXZ;

                    $grassFound = false;
                    if ($modX * $modX + $modZ * $modZ < 1.0) {
                        for ($yy = $yTo; $yy > $yFrom; $yy--) {
                            $modY = (($yy - 1) + 0.5 - $y) / $offsetY;
                            if (($modY > -0.7) && ($modX * $modX + $modY * $modY + $modZ * $modZ < 1.0)) {
                                $biome = CustomBiome::getBiome($chunk->getBiomeId($xx, $zz));
                                // if (!($biome instanceof CoveredBiome)) {
                                //     continue;
                                // }

                                $material = $chunk->getBlockId($xx, $yy, $zz);
                                $materialAbove = $chunk->getBlockId($xx, $yy + 1, $zz);
                                if ($material == Block::GRASS || $material == Block::MYCELIUM) {
                                    $grassFound = true;
                                }
                                //TODO: check this
//								if (this.isSuitableBlock(material, materialAbove, biome))
                                {
                                    // $rx = $chunk->getX() << 4 | $chunk->getX() % 16;
                                    // $rz = $chunk->getZ() << 4 | $chunk->getZ() % 16;
                                    if ($yy - 1 < 10) {
                                        $chunk->setBlock($xx, $yy, $zz, Block::LAVA);
                                    } else {
                                        $chunk->setBlock($xx, $yy, $zz, Block::AIR);

                                        // If grass was just deleted, try to
                                        // move it down
                                        if ($grassFound && ($chunk->getBlockId($xx, $yy - 1, $zz) == Block::DIRT)) {
                                            $chunk->setBlock($xx, $yy - 1, $zz, $biome->getSurfaceBlock($yy - 1));
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            if ($isLargeCave) {
                break;
            }
        }
    }

    protected function generateChunk(int $chunkX, int $chunkZ, Chunk $generatingChunkBuffer) : void {
        $i = $this->random->nextBoundedInt($this->random->nextBoundedInt($this->random->nextBoundedInt(self::$caveFrequency) + 1) + 1);

        if (self::$evenCaveDistribution) $i = self::$caveFrequency;
        if ($this->random->nextBoundedInt(100) >= self::$caveRarity) $i = 0;

        for ($j = 0; $j < $i; $j++) {
            $x = $chunkX * 16 + $this->random->nextBoundedInt(16);

            $y = 0.00;

            if (self::$evenCaveDistribution) {
                $y = self::numberInRange($random, self::$caveMinAltitude, self::$caveMaxAltitude);
            } else {
                $y = $this->random->nextBoundedInt($this->random->nextBoundedInt(self::$caveMaxAltitude - self::$caveMinAltitude + 1) + 1) + self::$caveMinAltitude;
            }

            $z = $chunkZ * 16 + $this->random->nextBoundedInt(16);

            $count = self::$caveSystemFrequency;
            $largeCaveSpawned = false;
            if ($this->random->nextBoundedInt(100) <= self::$individualCaveRarity) {
                $this->generateLargeCaveNode($this->random->nextLong(), $generatingChunkBuffer, $x, $y, $z);
                $largeCaveSpawned = true;
            }

            if (($largeCaveSpawned) || ($this->random->nextBoundedInt(100) <= self::$caveSystemPocketChance - 1)) {
                $count += self::numberInRange($this->random, self::$caveSystemPocketMinSize, self::$caveSystemPocketMaxSize);
            }
            while ($count > 0) {
                $count--;

                $f1 = $this->random->nextFloat() * 3.141593 * 2.0;
                $f2 = ($this->random->nextFloat() - 0.5) * 2.0 / 8.0;
                $f3 = $this->random->nextFloat() * 2.0 + $this->random->nextFloat();

                $this->generateCaveNode($this->random->nextLong(), $generatingChunkBuffer, $x, $y, $z, $f3, $f1, $f2, 0, 0, 1.0);
            }
        }
    }

    public static function numberInRange(Random $random, int $min, int $max) : int {
        return $min + $random->nextBoundedInt($max - $min + 1);
    }

}
