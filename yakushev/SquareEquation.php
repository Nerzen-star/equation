<?php

namespace yakushev;

use core\EquationInterface;
use Exception;

class SquareEquation extends LineEquation implements EquationInterface {

    protected function solveDiscriminant($a, $b, $c) {
        return $d = $b * $b - 4 * $a * $c;
    }

    public function solve(float $a, float $b, float $c = 0): array {
        if($a == 0) {
            return parent::solve($b, $c);
        }
        $discriminant = $this->solveDiscriminant($a, $b, $c);
        if($discriminant > 0) {
            MyLog::log('This is square Equation');
            $squareDiscriminant = sqrt($discriminant);
            return $this->x = array((-$b + $squareDiscriminant) / (2 * $a), (-$b - $squareDiscriminant) / (2 * $a));
        }elseif($discriminant == 0) {
            return $this->x = array(-$b / (2 * $a));
        }

        throw new YakushevException('No roots');
    }
}
