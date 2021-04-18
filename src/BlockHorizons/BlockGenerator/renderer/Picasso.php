<?php

namespace BlockHorizons\BlockGenerator\renderer;

use BlockHorizons\BlockGenerator\biomes\CustomBiomeSelector;
use BlockHorizons\BlockGenerator\map\BiomeMapGenerator;
use BlockHorizons\BlockGenerator\math\CustomRandom;
use pocketmine\math\Vector2;

trait Picasso
{


    public function makeMap(int $seed, int $radius = 500): void
    {
        make_map:

        $random = new CustomRandom($seed);
        $selector = new CustomBiomeSelector($random);

        $maker = new BiomeMapGenerator($selector);
        $map = $maker->createMap(new Vector2(0, 0), $radius, 16);

        if (extension_loaded("gd")) {
            $image = $maker->createImageFromMap($map);

            if ($image) {
                $fileName = $seed.mt_rand(0, 100).".jpg";
				imagejpeg($image, $this->getDataFolder().$fileName);
				$this->getLogger()->notice("Image of the map saved(Seed: $seed)!");
			} else {
				$this->getLogger()->error("Failed to save map");
			}
		} else {
			$this->getLogger()->error("Can not create image, gd extension not found!");
		}
		//goto make_map;
	}


}