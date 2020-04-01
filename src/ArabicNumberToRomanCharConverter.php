<?php


namespace Kata;


class ArabicNumberToRomanCharConverter
{
    private $dictionary = [
        1000 => 'M',
        900 => 'CM',
        500 => 'D',
        400 => 'CD',
        100 => 'C',
        90 => 'XC',
        50 => 'L',
        40 => 'XL',
        10 => 'X',
        9 => 'IX',
        5 => 'V',
        4 => 'IV',
        1 => 'I',
    ];
    private $result;

    public function convert(int $number): string
    {
        $this->validateArgument($number);
        $this->initResult();
        $this->determineRomanChars($number);

        return $this->result;
    }

    /**
     * @param int $number
     * @param $divisor
     * @param $romanCharForDivisor
     * @return int
     */
    private function handleDigit(int $number, $divisor, $romanCharForDivisor): int
    {
        $digit = (int)($number / $divisor);
        for ($i = 0; $i < $digit; $i++) {
            $this->result .= $romanCharForDivisor;
        }
        return $number % $divisor;
    }

    /**
     * @param int $number
     */
    private function validateArgument(int $number): void
    {
        if ($number >= 4000 || $number < 0) {
            throw new \InvalidArgumentException();
        }
    }

    private function initResult(): void
    {
        $this->result = '';
    }

    /**
     * @param int $number
     */
    private function determineRomanChars(int $number): void
    {
        $rest = $number;
        foreach ($this->dictionary AS $arabicNumber => $romanChar) {
            $rest = $this->handleDigit($rest, $arabicNumber, $romanChar);
        }
    }
}