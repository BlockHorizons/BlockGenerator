<?php
namespace BlockHorizons\BlockGenerator\math;

use pocketmine\utils\Random;

class CustomRandom extends Random {

    public function nextLong() : int {
    	return $this->nextSignedInt();
    }

    public static function __test() {
    	$r = new self(1337);
    	$r2 = clone $r;
        
    	echo "---- Testing nextBoundedInt ---".PHP_EOL;
    	for($i = 0; $i < 4 * 2; $i++) echo ($i + 1).": {$r2->nextBoundedInt(10)}/10".PHP_EOL;
    	echo "---- Testing nextInt ---- ".PHP_EOL;
    	for($i = 0; $i < 4 * 2; $i++) echo ($i + 1).": {$r->nextInt()}".PHP_EOL;
    }

}