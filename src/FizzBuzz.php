<?php
declare(strict_types=1);

namespace Kata;

final class FizzBuzz
{
    public function process(int $number): string
    {
        $output = '';
        if ($this->isFizz($number)) {
            $output .= 'Fizz';
        }


        if ($this->isBuzz($number)) {
            $output .= 'Buzz';
        }

        return $output ?: (string)$number;
    }

    private function isFizz(int $number): bool
    {
        return $this->isDivisableBy($number, 3);
    }

    private function isBuzz(int $number): bool
    {
        return $this->isDivisableBy($number, 5);
    }

    private function isDivisableBy(int $number, int $divisor): bool
    {
        return $number % $divisor === 0;
    }

}
