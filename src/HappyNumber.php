<?php


namespace Kata;


class HappyNumber
{
    private $numbers = [];
    private $checkedNumbers = [];

    private const HAPPY = true;
    private const UNHAPPY = false;

    public function __construct()
    {
        $this->numbers[self::HAPPY]   = [1]; // by definition one is happy :-)
        $this->numbers[self::UNHAPPY] = [];
    }

    public function isHappy(int $number, bool $firstCall = true): bool
    {
        if ($this->isHappyNumber($number)) {
            return $this->handleNumbers(self::HAPPY);
        }
        if ($this->isCheckedNumber($number)) {
            return $this->handleNumbers(self::UNHAPPY);
        }

        $this->rememberAlreadyCheckedNumbers($number, $firstCall);

        $sumOfSquares = $this->sumUpSquaresOfDigits($number);

        return $this->isHappy($sumOfSquares, false);
    }

    /**
     * @return bool
     */
    private function handleNumbers(bool $happy): bool
    {
        foreach ($this->checkedNumbers as $num) {
            if (!in_array($num, $this->numbers[$happy])) {
                $this->numbers[$happy][] = $num;
            }
        }
        $this->checkedNumbers = [];
        return $happy;
    }

    /**
     * @param int $number
     * @return bool
     */
    private function isHappyNumber(int $number): bool
    {
        return in_array($number, $this->numbers[true]);
    }

    /**
     * @param int $number
     * @return bool
     */
    private function isCheckedNumber(int $number): bool
    {
        return in_array($number, $this->checkedNumbers);
    }
    /**
     * @param int $rest
     * @return float|int
     */
    private function sumUpSquaresOfDigits(int $rest)
    {
        $sumOfSquares = 0;
        while ($rest !== 0) {
            $digit = $rest % 10;
            $sumOfSquares += $digit * $digit;
            $rest = (int)($rest / (int)10);
        }
        return $sumOfSquares;
    }

    /**
     * @param int $number
     * @param bool $firstCall
     */
    private function rememberAlreadyCheckedNumbers(int $number, bool $firstCall): void
    {
        if ($firstCall) {
            $this->checkedNumbers = [];
        }
        $this->checkedNumbers[] = $number;
    }

}
