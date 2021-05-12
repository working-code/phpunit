<?php
declare(strict_types=1);

require_once realpath(__DIR__ . '/../src') . DIRECTORY_SEPARATOR . 'functions.php';

use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testCountArguments()
    {
        $message = "Вы передали недостаточно аргументов";
        $this->assertEquals(calculator('+'), $message);
        $this->assertEquals(calculator('+', 1), $message);
        $this->assertNotEquals(calculator('+', 5, 4), $message);
    }

    public function testOperandsAllowed()
    {
        $operations = ['+', '-', '*', '/'];
        foreach ($operations as $value) {
            $this->assertNotEquals(calculator($value, 1, 5), "Недопустимая операция $value");
        }
    }

    public function testOperandsNotAllowed()
    {
        $operations = ['!', '#', '$', '%', '^'];
        foreach ($operations as $value) {
            $this->assertEquals(calculator($value, 1, 5), "Недопустимая операция $value");
        }
    }

    public function testDivision0()
    {
        for ($i = 0; $i < 100; $i++) {
            $operand1 = mt_rand(-100, 500);
            $this->assertEquals(calculator('/', $operand1, 0), "Деление на 0");
        }
    }

    public function testSum()
    {
        for ($i = 0; $i < 100; $i++) {
            $operand1 = mt_rand(-100, 500);
            $operand2 = mt_rand(-100, 500);
            $operand3 = mt_rand(-100, 500);
            $this->assertEquals(
                calculator('+', $operand1, $operand2, $operand3),
                ($operand1 + $operand2 + $operand3));
        }
    }

    public function testDivision()
    {
        for ($i = 0; $i < 100; $i++) {
            $operand1 = mt_rand(1, 1500);
            $operand2 = mt_rand(1, 1500);
            $operand3 = mt_rand(1, 1500);
            $this->assertEquals(
                calculator('/', $operand1, $operand2, $operand3),
                ($operand1 / $operand2 / $operand3));
        }
    }

    public function testMultiply()
    {
        for ($i = 0; $i < 100; $i++) {
            $operand1 = mt_rand(-100, 500);
            $operand2 = mt_rand(-100, 500);
            $operand3 = mt_rand(-100, 500);
            $this->assertEquals(
                calculator('*', $operand1, $operand2, $operand3),
                ($operand1 * $operand2 * $operand3));
        }
    }

    public function testSubtraction()
    {
        for ($i = 0; $i < 100; $i++) {
            $operand1 = mt_rand(-100, 500);
            $operand2 = mt_rand(-100, 500);
            $operand3 = mt_rand(-100, 500);
            $this->assertEquals(
                calculator('-', $operand1, $operand2, $operand3),
                ($operand1 - $operand2 - $operand3));
        }
    }
}