<?php

use PHPUnit\Framework\TestCase;
use yakushev\SquareEquation;
use yakushev\YakushevException;

class SquareEquationTest extends TestCase {

    private $squareEquation;

    protected function setUp(): void {
        $this->squareEquation = new SquareEquation();
    }

    protected function tearDown(): void {
        $this->squareEquation = null;
    }

    /**
     * @dataProvider providerSolve
     * @param float $a
     * @param float $b
     * @param float $c
     * @param array $result
     * @return void
     */
    public function testSolve(float $a, float $b, float $c, array $result): void {
        $this->assertEquals($result, $this->squareEquation->solve($a, $b, $c));
    }

    public function providerSolve() {
        return array(
            array(10, 25, 10, [-0.5, -2]),
            array(-1, 0, 16, [-4, 4]),
            array(0, 6, 42, [-7])
        );
    }

    /**
     * @dataProvider providerYakushevException
     * @param float $a
     * @param float $b
     * @param float $c
     * @param array $result
     * @return void
     */
    public function testYakushevException(float $a, float $b, float $c, array $result): void {
        $this->expectException(YakushevException::class);
        $this->expectExceptionMessage('No roots');
        $this->assertEquals($result, $this->squareEquation->solve($a, $b, $c));
    }

    public function providerYakushevException() {
        return array(
            array(14, 2, 1, [-52]),
            array(4, 2, 1, [-12])
        );
    }
}