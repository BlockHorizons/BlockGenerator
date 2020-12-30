<?php
namespace BlockHorizons\BlockGenerator\generators;

use BlockHorizons\BlockGenerator\biomes\CustomBiome;
use BlockHorizons\BlockGenerator\biomes\CustomBiomeSelector;
use BlockHorizons\BlockGenerator\math\CustomRandom;
use BlockHorizons\BlockGenerator\math\MathHelper;
use BlockHorizons\BlockGenerator\noise\NoiseGeneratorOctaves;
use BlockHorizons\BlockGenerator\noise\PerlinF;
use BlockHorizons\BlockGenerator\noise\PerlinNoiseGenerator;
use BlockHorizons\BlockGenerator\populator\BedrockPopulator;
use BlockHorizons\BlockGenerator\populator\CavePopulator;
use BlockHorizons\BlockGenerator\populator\GroundCoverPopulator;
use BlockHorizons\BlockGenerator\populator\RavinesPopulator;
use pocketmine\block\Block;
use pocketmine\block\BlockIds;
use pocketmine\block\Stone;
use pocketmine\level\biome\Biome;
use pocketmine\level\generator\biome\BiomeSelector;
use pocketmine\level\generator\object\OreType;
use pocketmine\level\generator\populator\Ore;
use pocketmine\math\Vector3;

/**
 * BlockGenerator is improved default generator
 */
class BlockGenerator extends CustomGenerator {

	protected static $BIOME_WEIGHTS = [];

    const SEA_HEIGHT = 64;

	protected $seaHeight = self::SEA_HEIGHT;

	/** @var NoiseGeneratorOctaves */
	public $scaleNoise;
	public $depthNoise;

	/** @var Populator[] */
	private $populators = [];
	/** @var Populator[] */
	private $generationPopulators = [];

	/** @var BiomeSelector */
	private $selector;

	private $biomes = [];
	private $depthRegion = [];
	private $mainNoiseRegion = [];
	private $minLimitRegion = [];
	private $maxLimitRegion = [];
	private $heightMap = [];
	
	private $minLimitPerlinNoise = null;
	private $maxLimitPerlinNoise = null;
	private $mainPerlinNoise = null;
	private $surfaceNoise = null;

    private $settings = [];

    private $seed = null;
    /**
     * @var float
     */
    private $localSeed1;
    /**
     * @var float
     */
    private $localSeed2;

    public function __construct(array $options = []){

        $seed = 1337; // some arbitrary value ;/
        $this->settings = ["seed" => $seed];
        $this->seed = $this->settings["seed"];
        // wtf am I doing here ? ^ xD
        $this->settings["populate"] = true;

		for ($i = -2; $i <= 2; ++$i) {
            for ($j = -2; $j <= 2; ++$j) {
                self::$BIOME_WEIGHTS[$i + 2 + ($j + 2) * 5] = ((float) (10.0 / sqrt((float) ($i * $i + $j * $j) + 0.2)));
            }
        }

        $this->random = new CustomRandom($seed);

        $this->localSeed1 = $this->random->nextSignedFloat();

        $this->localSeed2 = $this->random->nextSignedFloat();

        $this->random->setSeed($seed);

        $this->selector = new CustomBiomeSelector($this->random);



        $this->minLimitPerlinNoise = new NoiseGeneratorOctaves($this->random, 16);

        $this->maxLimitPerlinNoise = new NoiseGeneratorOctaves($this->random, 16);

        $this->mainPerlinNoise = new NoiseGeneratorOctaves($this->random, 8);

       //$this->surfaceNoise = new PerlinNoiseGenerator($this->random, 4);

        $this->scaleNoise = new NoiseGeneratorOctaves($this->random, 10);

        $this->depthNoise = new NoiseGeneratorOctaves($this->random, 16);


        // TODO
        //this should run before all other populators so that we don't do things like generate ground cover on bedrock or something

        $cover = new GroundCoverPopulator();
        $this->generationPopulators[] = $cover;

        $bedrock = new BedrockPopulator();
        $this->generationPopulators[] = $bedrock;

        $ores = new Ore();
        $ores->setOreTypes([
                new OreType(Block::get(BlockIds::COAL_ORE), 20, 17, 0, 128),
                new OreType(Block::get(BlockIds::IRON_ORE), 20, 9, 0, 64),
                new OreType(Block::get(BlockIds::REDSTONE_ORE), 8, 8, 0, 16),
                new OreType(Block::get(BlockIds::LAPIS_ORE), 1, 7, 0, 16),
                new OreType(Block::get(BlockIds::GOLD_ORE), 2, 9, 0, 32),
                new OreType(Block::get(BlockIds::DIAMOND_ORE), 1, 8, 0, 16),
                new OreType(Block::get(BlockIds::DIRT), 10, 33, 0, 128),
                new OreType(Block::get(BlockIds::GRAVEL), 8, 33, 0, 128),
                new OreType(Block::get(BlockIds::STONE, Stone::GRANITE), 10, 33, 0, 80),
                new OreType(Block::get(BlockIds::STONE, Stone::DIORITE), 10, 33, 0, 80),
                new OreType(Block::get(BlockIds::STONE, Stone::ANDESITE), 10, 33, 0, 80)
        ]);
        $this->populators[] = $ores;

        $caves = new CavePopulator($this->random);
        $this->populators[] = $caves;
        $this->cavePop = $caves;

        $ravines = new RavinesPopulator();
        $this->populators[] = $ravines;
        $this->ravinePop = $ravines;

        $this->populators = [];

        CustomBiome::init();
	}
	
	public function generateChunk(int $chunkX, int $chunkZ) : void {
        $baseX = $chunkX << 4;
        $baseZ = $chunkZ << 4;
        $this->random->setSeed($chunkX * $this->localSeed1 ^ $chunkZ * $this->localSeed2 ^ $this->seed);

        $chunk = $this->level->getChunk($chunkX, $chunkZ);

        //generate base noise values
        $depthRegion = $this->depthNoise->generateNoiseOctaves8($this->depthRegion, $chunkX * 4, $chunkZ * 4, 5, 5, 200.0, 200.0, 0.5);

        $this->depthRegion = $depthRegion;

        $mainNoiseRegion = $this->mainPerlinNoise->generateNoiseOctaves($this->mainNoiseRegion, $chunkX * 4, 0, $chunkZ * 4, 5, 33, 5, 684.412 / 60, 684.412 / 160, 684.412 / 60);

        $this->mainNoiseRegion = $mainNoiseRegion;

        $minLimitRegion = $this->minLimitPerlinNoise->generateNoiseOctaves($this->minLimitRegion, $chunkX * 4, 0, $chunkZ * 4, 5, 33, 5, 684.412, 684.412, 684.412);

        $this->minLimitRegion = $minLimitRegion;

        $maxLimitRegion = $this->maxLimitPerlinNoise->generateNoiseOctaves($this->maxLimitRegion, $chunkX * 4, 0, $chunkZ * 4, 5, 33, 5, 684.412, 684.412, 684.412);

        $this->maxLimitRegion = $maxLimitRegion;

        $heightMap = $this->heightMap;

        //generate heightmap and smooth biome heights
        $horizCounter = 0;
        $vertCounter = 0;
        for ($xSeg = 0; $xSeg < 5; ++$xSeg) {
            for ($zSeg = 0; $zSeg < 5; ++$zSeg) {

                $heightVariationSum = 0.0;
                $baseHeightSum = 0.0;
                $biomeWeightSum = 0.0;

                $biome = $this->selector->pickBiome($baseX + ($xSeg * 4), $baseZ + ($zSeg * 4));

                for ($xSmooth = -2; $xSmooth <= 2; ++$xSmooth) {
                    for ($zSmooth = -2; $zSmooth <= 2; ++$zSmooth) {

                        $biome1 = $this->selector->pickBiome($baseX + ($xSeg * 4) + $xSmooth, $baseZ + ($zSeg * 4) + $zSmooth);

                        $baseHeight = $biome1->getBaseHeight();
                        $heightVariation = $biome1->getHeightVariation();

                        $scaledWeight = self::$BIOME_WEIGHTS[$xSmooth + 2 + ($zSmooth + 2) * 5] / ($baseHeight + 2.0);

                        if ($biome1->getBaseHeight() > $biome->getBaseHeight()) {
                            $scaledWeight /= 2.0;
                        }

                        $heightVariationSum += $heightVariation * $scaledWeight;
                        $baseHeightSum += $baseHeight * $scaledWeight;
                        $biomeWeightSum += $scaledWeight;

                    }
                }

                $heightVariationSum = $heightVariationSum / $biomeWeightSum;
                $baseHeightSum = $baseHeightSum / $biomeWeightSum;
                $heightVariationSum = $heightVariationSum * 0.9 + 0.1;
                $baseHeightSum = ($baseHeightSum * 4.0 - 1.0) / 8.0;
                $depthNoise = $depthRegion[$vertCounter] / 8000.0;

                if ($depthNoise < 0.0) {
                    $depthNoise = -$depthNoise * 0.3;
                }

                $depthNoise = $depthNoise * 3.0 - 2.0;

                if ($depthNoise < 0.0) {
                    $depthNoise = $depthNoise / 2.0;

                    if ($depthNoise < -1.0) {
                        $depthNoise = -1.0;
                    }

                    $depthNoise = $depthNoise / 1.4;
                    $depthNoise = $depthNoise / 2.0;
                } else {
                    if ($depthNoise > 1.0) {
                        $depthNoise = 1.0;
                    }

                    $depthNoise = $depthNoise / 8.0;
                }



                ++$vertCounter;

                $baseHeightClone = $baseHeightSum;
                $heightVariationClone = $heightVariationSum;
                $baseHeightClone = $baseHeightClone + $depthNoise * 0.2;
                $baseHeightClone = $baseHeightClone * 8.5 / 8.0;
                $baseHeightFactor = 8.5 + $baseHeightClone * 4.0;

                for ($ySeg = 0; $ySeg < 33; ++$ySeg) {
                    $baseScale = ((float) $ySeg - $baseHeightFactor) * 12.0 * 128.0 / 256.0 / $heightVariationClone;

                    if ($baseScale < 0.0) {
                        $baseScale *= 4.0;
                    }

                    $minScaled = $minLimitRegion[$horizCounter] / 512.0;
                    $maxScaled = $maxLimitRegion[$horizCounter] / 512.0;
                    $noiseScaled = ($mainNoiseRegion[$horizCounter] / 10.0 + 1.0) / 2.0;
                    $clamp = MathHelper::denormalizeClamp($minScaled, $maxScaled, $noiseScaled) - $baseScale;

                    if ($ySeg > 29) {
                        $yScaled = ((float) ($ySeg - 29) / 3.0);
                        $clamp = $clamp * (1.0 - $yScaled) + -10.0 * $yScaled;
                    }

                    $heightMap[$horizCounter] = $clamp;

                    ++$horizCounter;
                }
            }
        }

        //place blocks
        for ($xSeg = 0; $xSeg < 4; ++$xSeg) {

            $xScale = $xSeg * 5;
            $xScaleEnd = ($xSeg + 1) * 5;

            for ($zSeg = 0; $zSeg < 4; ++$zSeg) {
                $zScale1 = ($xScale + $zSeg) * 33;
                $zScaleEnd1 = ($xScale + $zSeg + 1) * 33;
                $zScale2 = ($xScaleEnd + $zSeg) * 33;
                $zScaleEnd2 = ($xScaleEnd + $zSeg + 1) * 33;

                for ($ySeg = 0; $ySeg < 32; ++$ySeg) {
                    $height1 = $heightMap[$zScale1 + $ySeg];
                    $height2 = $heightMap[$zScaleEnd1 + $ySeg];
                    $height3 = $heightMap[$zScale2 + $ySeg];
                    $height4 = $heightMap[$zScaleEnd2 + $ySeg];
                    $height5 = ($heightMap[$zScale1 + $ySeg + 1] - $height1) * 0.125;
                    $height6 = ($heightMap[$zScaleEnd1 + $ySeg + 1] - $height2) * 0.125;
                    $height7 = ($heightMap[$zScale2 + $ySeg + 1] - $height3) * 0.125;
                    $height8 = ($heightMap[$zScaleEnd2 + $ySeg + 1] - $height4) * 0.125;

                    for ($yIn = 0; $yIn < 8; ++$yIn) {

                        $baseIncr = $height1;
                        $baseIncr2 = $height2;
                        $scaleY = ($height3 - $height1) * 0.25;
                        $scaleY2 = ($height4 - $height2) * 0.25;

                        for ($zIn = 0; $zIn < 4; ++$zIn) {

                            $scaleZ = ($baseIncr2 - $baseIncr) * 0.25;
                            $scaleZ2 = $baseIncr - $scaleZ;

                            for ($xIn = 0; $xIn < 4; ++$xIn) {
                                if (($scaleZ2 += $scaleZ) > 0.0) {
                                    $chunk->setBlockId($xSeg * 4 + $zIn, $ySeg * 8 + $yIn, $zSeg * 4 + $xIn, Block::STONE);
                                } elseif ($ySeg * 8 + $yIn <= $this->seaHeight) {
                                    $chunk->setBlockId($xSeg * 4 + $zIn, $ySeg * 8 + $yIn, $zSeg * 4 + $xIn, Block::STILL_WATER);
                                }
                            }

                            $baseIncr += $scaleY;
                            $baseIncr2 += $scaleY2;
                        }

                        $height1 += $height5;
                        $height2 += $height6;
                        $height3 += $height7;
                        $height4 += $height8;
                    }
                }
            }
        }


        for ($x = 0; $x < 16; $x++) {
            for ($z = 0; $z < 16; $z++) {
                $biome = $this->selector->pickBiome($baseX | $x, $baseZ | $z);
                $chunk->setBiomeId($x, $z, $biome->getId());
            }
        }

//        // DEBUG
//        $this->cavePop->populate($this->level, $chunkX, $chunkZ, $this->random, $chunk);
//        $this->ravinePop->populate($this->level, $chunkX, $chunkZ, $this->random, $chunk);
//
        //populate chunk
        foreach ($this->generationPopulators as $populator) {
            // add posibility to exclude populator using $settings variable # TODO
            $populator->populate($this->level, $chunkX, $chunkZ, $this->random, $chunk);
        }
	}

	public function populateChunk(int $chunkX, int $chunkZ) : void {
		$chunk = $this->level->getChunk($chunkX, $chunkZ);

        $this->random->setSeed(0xdeadbeef ^ ($chunkX << 8) ^ $chunkZ ^ $this->seed);

        foreach ($this->populators as $populator) {
            $populator->populate($this->level, $chunkX, $chunkZ, $this->random, $chunk);
        }
        
        $biome = CustomBiome::getBiome($chunk->getBiomeId(7, 7));

        if($this->settings['populate'] === false) return;
        $biome->populateChunk($this->level, $chunkX, $chunkZ, $this->random);
	}

	public function getName() : string {
        return "BlockGenerator";
	}

	public function getSpawn() : Vector3 {
		return new Vector3(0.5, 256, 0.5);
	}

    public function getSelector() : CustomBiomeSelector {
        return $this->selector;
    }

    public function getSettings() : array {
        return $this->settings;
    }


}
	