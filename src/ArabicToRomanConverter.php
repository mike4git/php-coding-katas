<?php declare(strict_types=1);

namespace Kata;

class ArabicToRomanConverter
{
    public function convert(int $number): string
    {
        $romanNumArray = [
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1
        ];

        $roman = '';

        foreach ($romanNumArray as $glyph => $num) {
            $roman .= str_repeat($glyph, (int)($number/$num));
            $number %= $num;
        }

        return $roman;
    }
}