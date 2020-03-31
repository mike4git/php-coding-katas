<?php declare(strict_types=1);

namespace Kata;

class ArabicToRomanConverter
{
    public function convert(int $number): String
    {
        $roman = '';

        $value = [
            1 => 'I',
            4 => 'IV',
            5 => 'V',
        ];


        if (isset($value[$number])) {
            return $value[$number];
        }
        if ((int)($number / 5) > 0) {
            $roman .= 'V';
        }
        for ($i = 1; $i <= ($number % 5); $i++) {
            $roman .= 'I';
        }

        return $roman;
    }
}