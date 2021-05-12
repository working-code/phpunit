<?php

function calculator(string $operation)
{
    if (func_num_args() < 3) {
        return "Вы передали недостаточно аргументов";
    }

    $operands = func_get_args();
    array_shift($operands);
    $operand1 = array_shift($operands);

    foreach ($operands as $operand) {
        if ($operation === '+') {
            $operand1 += $operand;
        } elseif ($operation === '-') {
            $operand1 -= $operand;
        } elseif ($operation === '*') {
            $operand1 *= $operand;
        } elseif ($operation === '/') {
            if ($operand === 0) {
                return "Деление на 0";
            }
            $operand1 /= $operand;
        } else {
            return "Недопустимая операция $operation";
        }
    }
    return $operand1;
}
