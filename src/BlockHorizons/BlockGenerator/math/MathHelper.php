<?php
namespace BlockHorizons\BlockGenerator\math;

class MathHelper {
	
	private function __construct(){}

	public static function denormalizeClamp(float $lowerBnd, float $upperBnd, float $slide) : float {
        return $slide < 0.0 ? $lowerBnd : ($slide > 1.0 ? $upperBnd : $lowerBnd + ($upperBnd - $lowerBnd) * $slide);
    }

}