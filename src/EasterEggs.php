<?php


namespace Kata;


use Kata\Exception\NotInOurGardenException;

class EasterEggs
{
    public function __construct(string $filename)
    {
    }

    /**
     * @param int $row
     * @param int $column
     * @throws NotInOurGardenException
     */
    public function whereAreEasterEggs(int $row, int $column) : string
    {
        return '';
    }
}