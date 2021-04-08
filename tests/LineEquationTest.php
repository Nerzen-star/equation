<?php

use PHPUnit\Framework\TestCase;
use yakushev\LineEquation;
use yakushev\YakushevException;

class LineEquationTest extends  TestCase {

    private $lineEquatoin;

    protected function setUp(): void {
        $this->lineEquatoin = new LineEquation();
    }

    protected function tearDown(): void {
        $this->lineEquatoin = null;
    }

    /**
     * @dataProvider providerSolve
     * @param float $a
     * @param float $b
     * @param array $result
     * @return void
     */
    public function testSolve(float $a, float $b, array $result): void {
        $this->assertEquals($result, $this->lineEquatoin->solve($a, $b));
    }

    public function providerSolve() {
        return array(
            array(6, 42, [-7]),
            array(3, 9, [-3])
        );
    }

    /**
     * @dataProvider providerYakushevException
     * @param float $a
     * @param float $b
     * @param array $result
     * @return void
     */
    public function testYakushevException(float $a, float $b, array $result): void {
        $this->expectException(YakushevException::class);
        $this->expectExceptionMessage('No roots');
        $this->assertEquals($result, $this->lineEquatoin->solve($a, $b));
    }

    public function providerYakushevException() {
        return array(
            array(0, 5, [0]),
            array(0, 9, [0])
        );
    }
}