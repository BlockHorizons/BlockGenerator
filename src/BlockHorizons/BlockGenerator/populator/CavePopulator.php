<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\populator;

use BlockHorizons\BlockGenerator\biomes\CustomBiome;
use BlockHorizons\BlockGenerator\biomes\type\CoveredBiome;
use BlockHorizons\BlockGenerator\math\CustomRandom;
use pocketmine\block\BlockLegacyIds;
use pocketmine\block\VanillaBlocks;
use pocketmine\utils\Random;
use pocketmine\world\ChunkManager;
use pocketmine\world\format\Chunk;
use pocketmine\world\generator\populator\Populator;

// Won't work
class CavePopulator implements Populator
{

	public static int $caveRarity = 7;
	public static int $caveFrequency = 40;
	public static int $caveMinAltitude = 8;//7
	public static int $caveMaxAltitude = 67;//40
	public static int $individualCaveRarity = 25;
	public static int $caveSystemFrequency = 1;
	public static int $caveSystemPocketChance = 0;//25
	public static int $caveSystemPocketMinSize = 0;
	public static int $caveSystemPocketMaxSize = 4;
	public static bool $evenCaveDistribution = false;

	public int $worldHeightCap = 256;
	protected int $checkAreaSize = 1;
	protected int $worldLong1, $worldLong2;

	private Random $random;

	public function __construct(private int $seed)
	{
	}

	public function populate(ChunkManager $world, int $chunkX, int $chunkZ, Random $random): void
	{
		$this->random = new CustomRandom($this->seed);

		$this->worldLong1 = $this->random->nextLong();
		$this->worldLong2 = $this->random->nextLong();

		$size = $this->checkAreaSize;

		for ($x = $chunkX - $size; $x <= $chunkX + $size; $x++) {
			for ($z = $chunkZ - $size; $z <= $chunkZ + $size; $z++) {
				echo 'Hey';
				$randomX = $x * $this->worldLong1;
				$randomZ = $z * $this->worldLong2;
				$this->random->setSeed($randomX ^ $randomZ ^ $this->seed);
				$this->generateChunk($chunkX, $chunkZ, $world);
			}
		}
	}

	protected function generateChunk(int $chunkX, int $chunkZ, ChunkManager $world): void
	{
		$i = $this->random->nextBoundedInt($this->random->nextBoundedInt($this->random->nextBoundedInt(self::$caveFrequency) + 1) + 1);

		if (self::$evenCaveDistribution) $i = self::$caveFrequency;
		if ($this->random->nextBoundedInt(100) >= self::$caveRarity) $i = 0;

		for ($j = 0; $j < $i; $j++) {
			echo 'i: ' . PHP_EOL;
			$x = $chunkX * 16 + $this->random->nextBoundedInt(16);

			if (self::$evenCaveDistribution) {
				$y = self::numberInRange($this->random, self::$caveMinAltitude, self::$caveMaxAltitude);
			} else {
				$y = $this->random->nextBoundedInt($this->random->nextBoundedInt(self::$caveMaxAltitude - self::$caveMinAltitude + 1) + 1) + self::$caveMinAltitude;
			}

			$z = $chunkZ * 16 + $this->random->nextBoundedInt(16);

			$count = self::$caveSystemFrequency;
			$largeCaveSpawned = false;
			if ($this->random->nextBoundedInt(100) <= self::$individualCaveRarity) {
				echo 'Generating individual cave' . PHP_EOL;
				$this->generateLargeCaveNode($this->random->nextLong(), $world, $chunkX, $chunkZ, $x, $y, $z);
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

				$this->generateCaveNode($this->random->nextLong(), $world, $chunkX, $chunkZ, $x, $y, $z, $f3, $f1, $f2, 0, 0, 1.0);
			}
		}
	}

	public static function numberInRange(Random $random, int $min, int $max): int
	{
		return $min + $random->nextBoundedInt($max - $min + 1);
	}

	protected function generateLargeCaveNode($seed, ChunkManager $world, int $chunkX, int $chunkZ, float $x, float $y, float $z): void
	{
		$this->generateCaveNode($seed, $world, $chunkX, $chunkZ, $x, $y, $z, 1.0 + $this->random->nextFloat() * 6.0, 0.0, 0.0, -1, -1, 0.5);
	}

	protected function generateCaveNode($seed, ChunkManager $world, int $chunkX, int $chunkZ, float $x, float $y, float $z, float $radius, float $angelOffset, float $angel, int $angle, int $maxAngle, float $scale): void
	{
		$realX = $chunkX * 16 + 8;
		$realZ = $chunkZ * 16 + 8;

		$f1 = 0.0;
		$f2 = 0.0;

		$localRandom = new CustomRandom($seed);

		if ($maxAngle <= 0) {
			$checkAreaSize = ($this->checkAreaSize * 8) * 16 - 16;
			$maxAngle = $checkAreaSize - $localRandom->nextBoundedInt($checkAreaSize / 4);
		}
		$isLargeCave = false;

		if ($angle == -1) {
			$angle = $maxAngle / 2;
			$isLargeCave = true;
		}

		$randomAngel = $localRandom->nextBoundedInt($maxAngle / 2) + $maxAngle / 4;
		$bigAngel = $localRandom->nextBoundedInt(6) == 0;

		echo 'Angle: ' . $angle . ' < maxAngle: ' . $maxAngle . PHP_EOL;
		for (; $angle < $maxAngle; $angle++) {
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
				$this->generateCaveNode($localRandom->nextLong(), $world, $chunkX, $chunkZ, $x, $y, $z, $localRandom->nextFloat() * 0.5 + 0.5, $angelOffset - 1.570796, $angel / 3.0, $angle, $maxAngle, 1.0);
				$this->generateCaveNode($localRandom->nextLong(), $world, $chunkX, $chunkZ, $x, $y, $z, $localRandom->nextFloat() * 0.5 + 0.5, $angelOffset + 1.570796, $angel / 3.0, $angle, $maxAngle, 1.0);
				return;
			}
			$ln = $localRandom->nextBoundedInt(4);
			if ((!$isLargeCave) && ($ln == 0)) {
				continue;
			}

			// Check if distance to working point (x and z) too larger than working radius (maybe ??)
			$distanceX = $x - $realX;
			$distanceZ = $z - $realZ;
			$angelDiff = $maxAngle - $angle;
			$newRadius = $radius + 2.0 + 16.0;
			echo 'Checking disatance ...' . PHP_EOL;
			if ($distanceX * $distanceX + $distanceZ * $distanceZ - $angelDiff * $angelDiff > $newRadius * $newRadius) {
				return;
			}
			echo 'Passed' . PHP_EOL;

			//Boundaries check.
			if (($x < $realX - 16.0 - $offsetXZ * 2.0) || ($z < $realZ - 16.0 - $offsetXZ * 2.0) || ($x > $realX + 16.0 + $offsetXZ * 2.0) || ($z > $realZ + 16.0 + $offsetXZ * 2.0)) {
				continue;
			}
			echo 'Passed 2' . PHP_EOL;

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

			$baseX = $chunkX * Chunk::EDGE_LENGTH;
			$baseZ = $chunkZ * Chunk::EDGE_LENGTH;

			for ($xx = $xFrom; (!$waterFound) && ($xx < $xTo); $xx++) {
				for ($zz = $zFrom; ($zz < $zTo); $zz++) {
					for ($yy = $yTo + 1; ($yy >= $yFrom - 1); $yy--) {
						if ($yy >= 0 && $yy < $this->worldHeightCap) {
							$block = $world->getBlockAt((int)$xx + $baseX, (int)$yy, (int)$zz + $baseZ);
							if ($block->getId() === BlockLegacyIds::WATER || $block->getId() == BlockLegacyIds::STILL_WATER) {
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

			$chunk = $world->getChunk($chunkX, $chunkZ);

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
								$biome = CustomBiome::getBiome($chunk->getBiomeId((int)$xx, (int)$zz));
								if (!($biome instanceof CoveredBiome)) {
									continue;
								}

								$block = $world->getBlockAt((int)$xx + $baseX, (int)$yy, (int)$zz + $baseZ);
								if ($block->getId() === BlockLegacyIds::GRASS || $block->getId() === BlockLegacyIds::MYCELIUM) {
									$grassFound = true;
								}
								echo 'Setting blocks ...' . PHP_EOL;
								if ($yy - 1 < 10) {
									$world->setBlockAt((int)$xx + $baseX, (int)$yy, (int)$zz + $baseZ, VanillaBlocks::LAVA());
								} else {
									$world->setBlockAt((int)$xx + $baseX, (int)$yy, (int)$zz + $baseZ, VanillaBlocks::AIR());

									if ($grassFound && ($world->getBlockAt((int)$xx + $baseX, (int)$yy - 1, (int)$zz + $baseZ)->getId() === BlockLegacyIds::DIRT)) {
										$world->setBlockAt((int)$xx + $baseX, (int)$yy - 1, (int)+$baseZ, $biome->getSurfaceBlock((int)$yy - 1));
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

}
