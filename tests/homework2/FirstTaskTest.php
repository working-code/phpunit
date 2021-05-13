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
    public function testDivision0($operand1, $operand2)
    {
        $this->expectException(Exception::class);
        calculator('/', $operand1, $operand2);
    }

    public function providerDivision0()
    {
        return [
            [0, 0],
            [-1, 0],
            [1, 0],
        ];
    }

    /**
     * @dataProvider providerSum
     */
    public function testSum($operand1, $operand2, $result)
    {
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
            [-1000, -500, -1500]
        ];
    }

    /**
     * @dataProvider providerDivision
     */
    public function testDivision($operand1, $operand2, $result)
    {
        $this->assertEquals(calculator('/', $operand1, $operand2), $result);

    }

    public function providerDivision()
    {
        return [
            [0, -10, 0],
            [0, 50, 0],
            [1, 2, 0.5],
            [1, -2, -0.5],
            [-1, 2, -0.5],
            [-1000, -500, 2]
        ];
    }

    /**
     * @dataProvider providerMultiply
     */
    public function testMultiply($operand1, $operand2, $result)
    {
        $this->assertEquals(calculator('*', $operand1, $operand2), $result);

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
            [-1000, -500, 500000]
        ];
    }

    /**
     * @dataProvider providerSubtraction
     */
    public function testSubtraction($operand1, $operand2, $result)
    {
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
            [-1000, -500, -500]
        ];
    }
}
