<?php
namespace BlockHorizons\BlockGenerator\biomes\impl\mesa;

class MesaPlateauBiome extends MesaBiome {

	public function __construct() {
		parent::__construct();

		$this->setBaseHeight(1.5);
        $this->setHeightVariation(0.025);

        $this->setMoundHeight(0);
	}

    public function getName() : string {
        return "Mesa Plateau";
    }

}
