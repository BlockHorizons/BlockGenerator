<?php
declare(strict_types=1);

namespace BlockHorizons\BlockGenerator\biomes\type;

use BlockHorizons\BlockGenerator\biomes\CustomBiome;
use pocketmine\block\Block;
use pocketmine\block\BlockLegacyIds;
use pocketmine\block\VanillaBlocks;

abstract class CoveredBiome extends CustomBiome
{

	/**
	 * A single block placed on top of the surface blocks
	 */
	public function getCoverBlock(int $y): Block
	{
		return VanillaBlocks::AIR();
	}

	/**
	 * The amount of times the surface block should be used
	 * <p>
	 * If &lt; 0 bad things will happen!
	 * </p>
	 */
	public function getSurfaceDepth(int $y): int
	{
		return 1;
	}

	/**
	 * Between cover and ground
	 */
	public abstract function getSurfaceBlock(int $y): Block;


	/**
	 * The amount of times the ground block should be used
	 * <p>
	 * If &lt; 0 bad things will happen!
	 * </p>
	 */
	public function getGroundDepth(int $y): int
	{
		return 4;
	}

	/**
	 * Between surface and stone
	 */
	public abstract function getGroundBlock(int $y): Block;

	/**
	 * The block used as stone/below all other surface blocks
	 */
	public function getStoneBlock(): Block
	{
		return VanillaBlocks::STONE();
	}

	/**
	 * Called before a new block column is covered. Biomes can update any relevant variables here before covering.
	 * <p>
	 * Biome covering is synchronized on the biome, so thread safety isn't an issue.
	 * </p>
	 */
	public function preCover(int $x, int $z): void
	{

	}

}