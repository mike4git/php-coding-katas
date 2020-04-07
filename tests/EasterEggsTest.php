<?php declare(strict_types=1);

namespace Kata\Tests;

use Kata\EasterEggs;
use Kata\Exception\NotInOurGardenException;
use PHPUnit\Framework\TestCase;

class EasterEggsTest extends TestCase
{
    private $easterEgg;

    public function dataProvider()
    {
        yield['single_egg.txt', 1, 1, 'Das Kind hat alle 1 Eier in 1 Schritten gefunden.'];
        yield['pair_of_eggs.txt', 1, 1, 'Du hast ein Ei gefunden'];
        yield['some_eggs_in_a_row.txt', 1, 1, 'Es sind 0 Eier in Deiner Nähe'];
        yield['some_eggs_in_a_row.txt', 1, 2, 'Es sind 1 Eier in Deiner Nähe'];
        yield['some_eggs_in_a_row.txt', 1, 4, 'Es sind 2 Eier in Deiner Nähe'];
        yield['some_eggs_in_a_row.txt', 1, 6, 'Es sind 1 Eier in Deiner Nähe'];
        yield['some_eggs_in_some_rows.txt', 1, 1, 'Es sind 2 Eier in Deiner Nähe'];
        yield['some_eggs_in_some_rows.txt', 2, 2, 'Es sind 2 Eier in Deiner Nähe'];
        yield['easter_eggs_1.txt', 4, 1, 'Es sind 0 Eier in Deiner Nähe'];
    }

    /**
     * @test
     * @param string $filename
     * @param int    $row
     * @param int    $column
     * @param string $output
     * @throws NotInOurGardenException
     * @dataProvider dataProvider
     */
    public function whereAreEasterEggsOneTimeCall(
        string $filename,
        int $row,
        int $column,
        string $output
    ): void {
        $this->easterEgg = new EasterEggs($filename);
        self::assertSame($output, $this->easterEgg->whereAreEasterEggs($row, $column));
    }

    /**
     * @test
     * @throws NotInOurGardenException
     */
    public function whereAreEasterEggsMultipleCalls(): void
    {
        $this->easterEgg = new EasterEggs('easter_eggs_1.txt');

        $this->easterEgg->whereAreEasterEggs(1, 4);
        $this->easterEgg->whereAreEasterEggs(2, 2);
        $this->easterEgg->whereAreEasterEggs(4, 4);
        $this->easterEgg->whereAreEasterEggs(3, 4);

        self::assertSame(
            'Das Kind hat alle 4 Eier in 5 Schritten gefunden.',
            $this->easterEgg->whereAreEasterEggs(4, 5)
        );
    }

    /**
     * @test
     * @throws NotInOurGardenException
     */
    public function whereAreEasterEggsSingleFailureCall(): void
    {
        $this->easterEgg = new EasterEggs('easter_eggs_1.txt');

        $this->expectException(NotInOurGardenException::class);

        $this->easterEgg->whereAreEasterEggs(7, 8);
    }
}
