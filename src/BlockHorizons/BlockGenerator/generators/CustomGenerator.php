<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\generators;

use pocketmine\world\generator\Generator;

abstract class CustomGenerator extends Generator
{

	protected array $settings;

	public function __construct(array $options = [])
	{
		parent::__construct($options['seed'] ?? 0, md5((string) time()));

		$this->settings = $options;
	}

	public function getSettings(): array
	{
		return $this->settings;
	}

}
