<?php

namespace BlockHorizons\BlockGenerator\noise;

use pocketmine\level\generator\noise\Noise;
use pocketmine\utils\Random;

class PerlinF extends Noise
{

    protected $perm = [];
    protected $offsetX = 0;
    protected $offsetY = 0;
    protected $offsetZ = 0;

    public function __construct(Random $random, float $octaves, float $persistence, float $expansion)
    {
        $this->octaves = $octaves;
        $this->persistence = $persistence;
        $this->expansion = $expansion;
        $this->offsetX = $random->nextFloat() * 256;
        $this->offsetY = $random->nextFloat() * 256;
        $this->offsetZ = $random->nextFloat() * 256;
        $this->perm = [];
        for ($i = 0; $i < 256; ++$i) {
            $this->perm[$i] = $random->nextBoundedInt(256);
        }
        for ($i = 0; $i < 256; ++$i) {
            $pos = $random->nextBoundedInt(256 - $i) + $i;
            $old = $this->perm[$i];
            $this->perm[$i] = $this->perm[$pos];
            $this->perm[$pos] = $old;
            $this->perm[$i + 256] = $this->perm[$i];
        }
    }

    public function getNoise2D($x, $y)
    {
        return $this->getNoise3D($x, $y, 0);
    }

    public function getNoise3D($x, $y, $z)
    {
        $x += $this->offsetX;
        $y += $this->offsetY;
        $z += $this->offsetZ;

        $floorX = (int)$x;
        $floorY = (int)$y;
        $floorZ = (int)$z;

        $x1 = $floorX & 0xFF;
        $y1 = $floorY & 0xFF;
        $z1 = $floorZ & 0xFF;

        $x -= $floorX;
        $y -= $floorY;
        $z -= $floorZ;

        //Fade curves
        //fX = fade(x);
        //fY = fade(y);
        //fZ = fade(z);
        $fX = $x * $x * $x * ($x * ($x * 6 - 15) + 10);
        $fY = $y * $y * $y * ($y * ($y * 6 - 15) + 10);
        $fZ = $z * $z * $z * ($z * ($z * 6 - 15) + 10);

        //Cube corners
        $A = $this->perm[$x1] + $y1;
        $B = $this->perm[$x1 + 1] + $y1;

        $AA = $this->perm[$A] + $z1;
        $AB = $this->perm[$A + 1] + $z1;
        $BA = $this->perm[$B] + $z1;
        $BB = $this->perm[$B + 1] + $z1;

        $AA1 = self::grad($this->perm[$AA], $x, $y, $z);
        $BA1 = self::grad($this->perm[$BA], $x - 1, $y, $z);
        $AB1 = self::grad($this->perm[$AB], $x, $y - 1, $z);
        $BB1 = self::grad($this->perm[$BB], $x - 1, $y - 1, $z);
        $AA2 = self::grad($this->perm[$AA + 1], $x, $y, $z - 1);
        $BA2 = self::grad($this->perm[$BA + 1], $x - 1, $y, $z - 1);
        $AB2 = self::grad($this->perm[$AB + 1], $x, $y - 1, $z - 1);
        $BB2 = self::grad($this->perm[$BB + 1], $x - 1, $y - 1, $z - 1);

        $xLerp11 = $AA1 + $fX * ($BA1 - $AA1);

        $zLerp1 = $xLerp11 + $fY * ($AB1 + $fX * ($BB1 - $AB1) - $xLerp11);

        $xLerp21 = $AA2 + $fX * ($BA2 - $AA2);

        return $zLerp1 + $fZ * ($xLerp21 + $fY * ($AB2 + $fX * ($BB2 - $AB2) - $xLerp21) - $zLerp1);
    }

    /**
     * PocketMine doesn't use scalar type hints on this one
     * @param $hash
     * @param $x
     * @param $y
     * @param $z
     * @return float
     */
    public static function grad($hash, $x, $y, $z)
    {
        $hash &= 15;
        $u = $hash < 8 ? $x : $y;
        $v = $hash < 4 ? $y : (($hash === 12 || $hash === 14) ? $x :
            $z);

        return (($hash & 1) === 0 ? $u : -$u) + (($hash & 2) === 0 ? $v : -$v);
    }

}
