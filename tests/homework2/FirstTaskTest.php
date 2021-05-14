<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class FirstTaskTest extends TestCase
{
    protected function setUp(): void
    {
        require_once realpath(__DIR__ . '/../../src') . DIRECTORY_SEPARATOR . 'functions.php';
    }

    public function testCountArguments()
    {
        $this->expectException(Exception::class);
        calculator('+');
        calculator('+', 1);
    }

    public function testOperandsAllowed()
    {
        $operations = ['+', '-', '*', '/'];
        foreach ($operations as $value) {
            $this->assertNotEmpty(calculator($value, 1, 5));
        }
    }

    public function testOperandsNotAllowed()
    {
        $operations = ['!', '#', '$', '%', '^'];
        foreach ($operations as $value) {
            $this->expectException(Exception::class);
            calculator($value, 1, 5);
        }
    }

    /**
     * @dataProvider providerDivision0
     */
    public function testDivision0($operand1, $operand2, $result)
    {
        if (is_null($result)) {
            $this->expectException(TypeError::class);
        }
        $this->expectException(Exception::class);
        calculator('/', $operand1, $operand2);
    }

    public function providerDivision0()
    {
        return [
            [0, 0, 0],
            [-1, 0, 0],
            [1, 0, 0],

            [-1.58, 0, 0],
            [1.74, 0, 0],

            ['-500.3fs', 0, null],
            [true, 0, null],
            [[], 0, null]
        ];
    }

    /**
     * @dataProvider providerSum
     */
    public function testSum($operand1, $operand2, $result)
    {
        if (is_null($result)) {
            $this->expectException(TypeError::class);
        }
        $this->assertEquals(calculator('+', $operand1, $operand2), $result);
    }

    public function providerSum(): array
    {
        return [
            [0, 0, 0],
            [0, -10, -10],
            [0, 50, 50],
            [1, 0, 1],
            [1, 2, 3],
            [1, -2, -1],
            [-1, 2, 1],
            [-1000, 0, -1000],
            [-1000, -500, -1500],

            [0, 0, 0],
            [0, -10.56, -10.56],
            [0, 50.65, 50.65],
            [1.54, 0, 1.54],
            [1.34, 2.06, 3.4],
            [1.87, -2.87, -1],
            [-1.65, 2.74, 1.09],
            [-1000.54, 0, -1000.54],
            [-1000.87, -500.5, -1501.37],

            [-1000.3, '-500.3fs', null],
            [-1000.3, 'true', null],
            [[], 0.6, null],
            [5, '0.6', 5.6]
        ];
    }

    /**
     * @dataProvider providerDivision
     */
    public function testDivision($operand1, $operand2, $result)
    {
        if (is_null($result)) {
            $this->expectException(TypeError::class);
        }
        $calcResult = round(calculator('/', $operand1, $operand2), 2);
        $this->assertEquals($calcResult, $result);
    }

    public function providerDivision()
    {
        return [
            [0, -10, 0],
            [0, 50, 0],
            [1, 2, 0.5],
            [1, -2, -0.5],
            [-1, 2, -0.5],
            [-1000, -500, 2],

            [0, -10.56, 0],
            [0, 50.77, 0],
            [1.9, 2.58, 0.74],
            [1.9, -2.1, -0.9],
            [-1.98, 2.67, -0.74],
            [-1000.91, -500.3, 2],

            [-1000.3, '-500.3fs', null],
            [-1000.3, 'true', null],
            [[], 0.6, null],
            [5, '0.6', 8.33]
        ];
    }

    /**
     * @dataProvider providerMultiply
     */
    public function testMultiply($operand1, $operand2, $result)
    {
        if (is_null($result)) {
            $this->expectException(TypeError::class);
        }
        $calcResult = round(calculator('*', $operand1, $operand2), 2);
        $this->assertEquals($calcResult, $result);
    }

    public function providerMultiply()
    {
        return [
            [0, 0, 0],
            [0, -10, 0],
            [0, 50, 0],
            [1, 0, 0],
            [1, 2, 2],
            [1, -2, -2],
            [-1, 2, -2],
            [-1000, 0, 0],
            [-1000, -500, 500000],

            [0, -10.35, 0],
            [0, 50.125, 0],
            [1.99, 0, 0],
            [1.33, 2.12, 2.82],
            [1.55, -2.1, -3.26],
            [-1.29, 2.6, -3.35],
            [-1000.5, 0, 0],
            [-1000.3, -500.3, 500450.09],

            [-1000.3, '-500.3fs', null],
            [-1000.3, 'true', null],
            [[], 0.6, null],
            [5, '0.6', 3]
        ];
    }

    /**
     * @dataProvider providerSubtraction
     */
    public function testSubtraction($operand1, $operand2, $result)
    {
        if (is_null($result)) {
            $this->expectException(TypeError::class);
        }
        $this->assertEquals(calculator('-', $operand1, $operand2), $result);
    }

    public function providerSubtraction(): array
    {
        return [
            [0, 0, 0],
            [0, -10, 10],
            [0, 50, -50],
            [1, 0, 1],
            [1, 2, -1],
            [1, -2, 3],
            [-1, 2, -3],
            [-1000, 0, -1000],
            [-1000, -500, -500],

            [0, -10.35, 10.35],
            [0, 50.125, -50.125],
            [1.99, 0, 1.99],
            [1.33, 2.12, -0.79],
            [1.55, -2.1, 3.65],
            [-1.29, 2.6, -3.89],
            [-1000.5, 0, -1000.5],
            [-1000.3, -500.3, -500],

            [-1000.3, '-500.3fs', null],
            [-1000.3, 'true', null],
            [[], 0.6, null],
            [5, '0.6', 4.4]
        ];
    }
}
