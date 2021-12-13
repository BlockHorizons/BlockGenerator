<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\impl\forest;

use BlockHorizons\BlockGenerator\biomes\type\GrassyBiome;
use BlockHorizons\BlockGenerator\populator\TreePopulator;
use pocketmine\block\utils\TreeType;

class ForestBiome extends GrassyBiome
{

	const TYPE_NORMAL = 0;
	const TYPE_BIRCH = 1;
	const TYPE_BIRCH_TALL = 2;

	protected int $type;

	public function __construct(int $type = self::TYPE_NORMAL)
	{
		parent::__construct();

		$this->type = $type;

		$trees = new TreePopulator(
			type: $type === self::TYPE_NORMAL
				? TreeType::OAK()
				: TreeType::BIRCH(),
			super: $type === self::TYPE_BIRCH_TALL
		);
		$trees->setBaseAmount($type === self::TYPE_NORMAL ? 3 : 6);
		$this->addPopulator($trees);

		if ($type == self::TYPE_NORMAL) {
			//normal forest biomes have both oak and birch trees
			$trees = new TreePopulator(TreeType::BIRCH());
			$trees->setBaseAmount(3);
			$this->addPopulator($trees);
		}
	}

	public function getType(): int
	{
		return $this->type;
	}

	public function getName(): string
	{
		return match ($this->type) {
			self::TYPE_BIRCH => "Birch Forest",
			self::TYPE_BIRCH_TALL => "Birch Forest M",
			default => "Forest",
		};
	}
}
