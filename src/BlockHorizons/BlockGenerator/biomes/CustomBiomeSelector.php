<?php

namespace BlockHorizons\BlockGenerator\biomes;

use pocketmine\level\biome\Biome;
use pocketmine\level\generator\biome\BiomeSelector;
use pocketmine\level\generator\noise\Simplex;
use pocketmine\utils\Random;

class CustomBiomeSelector extends BiomeSelector
{

    public $biome;
    private $ocean;
    private $river;
    private $hills;
    private $rain;
    /**
     * @var Simplex
     */
    private Simplex $_temperature;

    public function __construct(Random $random)
    {
        parent::__construct($random);

        $this->_temperature = new Simplex($random, 2, 1 / 8, 1 / 2048);
        $this->rain = new Simplex($random, 2, 1 / 8, 1 / 2048);
        $this->river = new Simplex($random, 6, 2 / 4, 1 / 1024);
        $this->ocean = new Simplex($random, 6, 2 / 4, 1 / 2048);
        $this->hills = new Simplex($random, 2, 2 / 4, 1 / 2048);
    }

    public function pickBiome($x, $z): Biome
    {
        $noiseOcean = $this->ocean->noise2D($x, $z, true);
        $noiseRiver = $this->river->noise2D($x, $z, true);
        $temperature = $this->_temperature->noise2D($x, $z, true);
        $rainfall = $this->rain->noise2D($x, $z, true);
        $hills = $this->hills->noise2D($x, $z, true);

        // echo "noiseOcean: ".$noiseOcean.PHP_EOL;
        // echo "noiseRiver: ".$noiseRiver.PHP_EOL;
        // echo "temperature: ".$temperature.PHP_EOL;
        // echo "rainfall: ".$rainfall.PHP_EOL;
        // echo "------------------------------".PHP_EOL;
        //
        // $lowest = 0;
        // for($i = 0; true; $i++) {
        //     $noiseOcean = $this->ocean->noise2D(mt_rand(PHP_INT_MIN, PHP_INT_MAX), mt_rand(PHP_INT_MIN, PHP_INT_MAX), true);

        //     if($noiseOcean < $lowest) {
        //         $lowest = $noiseOcean;
        //         echo "Lowest: ".$lowest.PHP_EOL." Iteration: $i".PHP_EOL;
        //     }
        // }

        $biome = CustomBiome::PLAINS;

        if ($noiseOcean < -0.16) {
            if ($noiseOcean < -0.70) {
                if ($noiseOcean < -0.745) {
                    $biome = CustomBiome::MUSHROOM_ISLAND;
                } else {
                    $biome = CustomBiome::MUSHROOM_ISLAND_SHORE;
                }
            } else {
                if ($rainfall < 0.0) {
                    $biome = CustomBiome::OCEAN;
//                } elseif ($temperature < 0) {
//                    $biome = CustomBiome::FROZEN_OCEAN;
                } else {
                    $biome = CustomBiome::DEEP_OCEAN;
                }
            }
        } elseif (abs($noiseRiver) < 0.04) {
            if ($temperature < -0.3) {
                $biome = CustomBiome::FROZEN_RIVER;
            } else {
                $biome = CustomBiome::RIVER;
            }
        } else {
            if ($temperature < -0.379) {
                //freezing
                if ($noiseOcean < -0.12) {
                    $biome = CustomBiome::COLD_BEACH;
                } elseif ($rainfall < 0) {
                    if ($hills < -0.1) {
                        $biome = CustomBiome::COLD_TAIGA;
                    } elseif ($hills < 0.2) {
                        $biome = CustomBiome::COLD_TAIGA_HILLS;
                    } else {
                        $biome = CustomBiome::COLD_TAIGA_M;
                    }
                } else {
                    if ($hills < 0.7) {
                        $biome = CustomBiome::ICE_PLAINS;
                    } else {
                        $biome = CustomBiome::ICE_PLAINS_SPIKES;
                    }
                }
            } elseif ($noiseOcean < -0.12) {
                if ($noiseOcean < -0.1 && $hills > 0.5) {
                    $biome = CustomBiome::STONE_BEACH;
                } else {
                    $biome = CustomBiome::BEACH;
                }
            } elseif ($temperature < 0) {
                //cold
                if ($hills < -0.4) {
                    if ($rainfall < -0.5) {
                        $biome = CustomBiome::EXTREME_HILLS_M;
                    } elseif ($rainfall > 0.5) {
                        $biome = CustomBiome::EXTREME_HILLS_PLUS_M;
                    } elseif ($rainfall < 0) {
                        $biome = CustomBiome::EXTREME_HILLS;
                    } else {
                        $biome = CustomBiome::EXTREME_HILLS_PLUS;
                    }
                } else {
                    if ($rainfall < -0.25) {
                        if ($hills > 0.5) {
                            $biome = CustomBiome::MEGA_TAIGA_HILLS;
                        } else {
                            $biome = CustomBiome::MEGA_TAIGA;
                        }
                    } elseif ($hills > 0.5) {
                        $biome = CustomBiome::TAIGA_HILLS;
                    } elseif ($rainfall > 0.35) {
                        $biome = CustomBiome::MEGA_SPRUCE_TAIGA;
                    } elseif ($rainfall < 0.2) {
                        $biome = CustomBiome::TAIGA;
                    } else {
                        $biome = CustomBiome::TAIGA_M;
                    }
                }
            } elseif ($temperature < 0.5) {
                //normal
                if ($temperature < 0.25) {
                    if ($rainfall < 0) {
                        if ($noiseOcean < 0) {
                            $biome = CustomBiome::SUNFLOWER_PLAINS;
                        } else {
                            $biome = CustomBiome::PLAINS;
                        }
                    } elseif ($rainfall < 0.25) {
                        if ($hills < 0.2) {
                            $biome = CustomBiome::FOREST_HILLS;
                        } elseif ($noiseOcean < 0) {
                            $biome = CustomBiome::FLOWER_FOREST;
                        } else {
                            $biome = CustomBiome::FOREST;
                        }
                    } else {
                        if ($noiseOcean < 0) {
                            if ($hills > 0.15) {
                                $biome = CustomBiome::BIRCH_FOREST_HILLS_M;
                            } else {
                                $biome = CustomBiome::BIRCH_FOREST_M;
                            }
                        } else {
                            if ($hills > 0.4) {
                                $biome = CustomBiome::BIRCH_FOREST_HILLS;
                            } else {
                                $biome = CustomBiome::BIRCH_FOREST;
                            }
                        }
                    }
                } else {
                    if ($rainfall < -0.2) {
                        if ($noiseOcean < 0) {
                            $biome = CustomBiome::SWAMPLAND_M;
                        } else {
                            $biome = CustomBiome::SWAMP;
                        }
                    } elseif ($rainfall > 0.1) {
                        if ($noiseOcean < 0.155) {
                            if ($hills < -0.5) {
                                $biome = CustomBiome::JUNGLE_HILLS;
                            } elseif ($rainfall < 0.15) {
                                $biome = CustomBiome::JUNGLE_EDGE;
                            } elseif ($noiseOcean < 0.1) {
                                if ($rainfall < 0.16) {
                                    $biome = CustomBiome::JUNGLE_EDGE_M;
                                } else {
                                    $biome = CustomBiome::JUNGLE_M;
                                }
                            } else {
                                $biome = CustomBiome::JUNGLE;
                            }
                        }
                    } else {
                        if ($noiseOcean < 0) {
                            $biome = CustomBiome::ROOFED_FOREST_M;
                        } else {
                            $biome = CustomBiome::ROOFED_FOREST;
                        }
                    }
                }
            } else {
                //hot
                if ($rainfall < 0) {
                    if ($noiseOcean < 0) {
                        $biome = CustomBiome::DESERT_M;
                    } elseif ($hills < 0) {
                        $biome = CustomBiome::DESERT_HILLS;
                    } else {
                        $biome = CustomBiome::DESERT;
                    }
                } elseif ($rainfall > 0.4) {
                    if ($noiseOcean < 0.155) {
                        if ($hills < 0) {
                            $biome = CustomBiome::SAVANNA_PLATEAU_M;
                        } else {
                            $biome = CustomBiome::SAVANNA_M;
                        }
                    } else {
                        if ($hills < 0.32) {
                            $biome = CustomBiome::SAVANNA_PLATEAU;
                        } else {
                            $biome = CustomBiome::SAVANNA;
                        }
                    }
                } else {
                    if ($noiseOcean < 0) {
                        if ($hills < 0) {
                            $biome = CustomBiome::MESA_PLATEAU_F;
                        } else {
                            $biome = CustomBiome::MESA_PLATEAU_F_M;
                        }
                    } elseif ($hills < 0) {
                        if ($noiseOcean < 0.2) {
                            $biome = CustomBiome::MESA_PLATEAU_M;
                        } else {
                            $biome = CustomBiome::MESA_PLATEAU;
                        }
                    } else {
                        if ($noiseOcean < 0.1) {
                            $biome = CustomBiome::MESA_BRYCE;
                        } else {
                            $biome = CustomBiome::MESA;
                        }
                    }
                }
            }
        }

        $biome = CustomBiome::getBiome($biome);
        return $biome;
    }

    protected function lookup(float $temperature, float $rainfall): int
    {
        return 0;
    }

}