<?php

namespace BlockHorizons\BlockGenerator\biomes\type;

use BlockHorizons\BlockGenerator\biomes\CustomBiome;
use pocketmine\block\Block;

abstract class CoveredBiome extends CustomBiome
{

    /**
     * A single block placed on top of the surface blocks
     *
     * @param int $y
     * @return cover block
     */
    public function getCoverBlock(int $y): int
    {
        return Block::AIR;
    }

    /**
     * The amount of times the surface block should be used
     * <p>
     * If &lt; 0 bad things will happen!
     * </p>
     *
     * @param y y
     * @return surface depth
     */
    public function getSurfaceDepth(int $y): int
    {
        return 1;
    }

    /**
     * Between cover and ground
     *
     * @param y y
     * @return surface block
     */
    public abstract function getSurfaceBlock(int $y): int;

    /**
     * The metadata of the surface block
     *
     * @param y y
     * @return surface meta
     */
    public function getSurfaceMeta(int $y): int
    {
        return 0;
    }

    /**
     * The amount of times the ground block should be used
     * <p>
     * If &lt; 0 bad things will happen!
     *
     * @param y y
     * @return ground depth
     */
    public function getGroundDepth(int $y): int
    {
        return 4;
    }

    /**
     * Between surface and stone
     *
     * @param y y
     * @return ground block
     */
    public abstract function getGroundBlock(int $y): int;

    /**
     * The metadata of the ground block
     *
     * @param y y
     * @return ground meta
     */
    public function getGroundMeta(int $y): int
    {
        return 0;
    }

    /**
     * The block used as stone/below all other surface blocks
     *
     * @return stone block
     */
    public function getStoneBlock(): int
    {
        return Block::STONE;
    }

    /**
     * Called before a new block column is covered. Biomes can update any relevant variables here before covering.
     * <p>
     * Biome covering is synchronized on the biome, so thread safety isn't an issue.
     * </p>
     *
     * @param x x
     * @param z z
     */
    public function preCover(int $x, int $z)
    {

    }

}