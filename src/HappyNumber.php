<?php


namespace Kata;


class HappyNumber
{
    private $alreadyCheckedNumbers = [];

    public function isHappy(int $number): bool
    {
        if ($number === 1) {
            return true;
        }
        if (in_array($number, $this->alreadyCheckedNumbers)) {
            return false;
        }
        $digit = 1;
        $rest = $number;
        $this->alreadyCheckedNumbers[] = $number;
        $sumOfSquares = $this->sumUpSquaresOfDigits($rest);
        return $this->isHappy($sumOfSquares);
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
}