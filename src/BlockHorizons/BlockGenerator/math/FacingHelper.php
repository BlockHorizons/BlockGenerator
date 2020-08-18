<?php
namespace BlockHorizons\BlockGenerator\math;

use pocketmine\math\Facing;

class FacingHelper {

	public static function xOffset(int $face) : int {
		return self::offset($face, Facing::AXIS_X);
	}

	public static function zOffset(int $face) : int {
		return self::offset($face, Facing::AXIS_Z);
	}

	public static function yOffset(int $face) : int {
		return self::offset($face, Facing::AXIS_Y);
	}

	public static function offset(int $face, int $axis) : int {
		return (Facing::axis($face) === $axis ? (($face % 2) > 0 ? 1 : -1) : 0);
	}

	public static function random(array $faces) : int {
		return $faces[mt_rand(0, count($faces) - 1)];
	}

	public static function __test() {
		// N
		// S
		// w
		// E
		// U
		// D
		$faces = [
			"North" => Facing::NORTH,
			"South" => Facing::SOUTH,
			"West" => Facing::WEST,
			"East" => Facing::EAST,
			"Up" => Facing::UP,
			"Down" => Facing::DOWN
		];
		foreach($faces as $name => $face) {
			echo " ---- Face: $name ----".PHP_EOL;
			echo " xOffset: ".FacingHelper::xOffset($face).PHP_EOL;
			echo " yOffset: ".FacingHelper::yOffset($face).PHP_EOL;
			echo " zOffset: ".FacingHelper::zOffset($face).PHP_EOL;
		}
	}

}