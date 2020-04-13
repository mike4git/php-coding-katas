<?php declare(strict_types=1);

namespace Kata\Tests;

use Kata\EasterEggs;
use Kata\Exception\NotInOurGardenException;
use PHPUnit\Framework\TestCase;

class EasterEggsTest extends TestCase
{

    /**
     * @test
     * @dataProvider createSampleGardens
     */
    public function whereAreEasterEggs(string $filename, int $row, int $col, string $expectedResult): void
    {
        $easterEgg = new EasterEggs($filename);
        self::assertSame($expectedResult,
            $easterEgg->whereAreEasterEggs($row, $col)
        );
    }

    public function createSampleGardens(): iterable
    {
        return [
            'Alle Eier gefunden:' =>               ['Resources/single_egg.txt', 1,1,'Das Kind hat alle 1 Eier in 1 Schritten gefunden.'],
            'Nicht alle Eier gefunden:' =>         ['Resources/two_eggs.txt', 1,1,'Du hast ein Ei gefunden.'],
            'Ein Ei rechts:' =>                    ['Resources/one_egg_near_by.txt', 1,1,'Du hast 1 Eier in Deiner Nähe.'],
            'Zwei Eier - links und rechts:' =>     ['Resources/two_eggs_near_by.txt', 1,2,'Du hast 2 Eier in Deiner Nähe.'],
            'Ein Ei über mir:' =>                  ['Resources/one_egg_above.txt', 2,1,'Du hast 1 Eier in Deiner Nähe.'],
            'Ein Ei schräg rechts und drunter:' => ['Resources/multi_eggs_in_multi_rows.txt', 3,1,'Du hast 2 Eier in Deiner Nähe.'],
            'Eier überall:' =>                     ['Resources/eggs_all_around.txt', 2,2,'Du hast 8 Eier in Deiner Nähe.'],
        ];
    }

    public function testFoundAllEggs()
    {
        $easteregg = new EasterEggs('Resources/mikes_garden.txt');
        $easteregg->whereAreEasterEggs(1,4);
        $easteregg->whereAreEasterEggs(2,2);
        $easteregg->whereAreEasterEggs(4,4);
        self::assertSame('Das Kind hat alle 4 Eier in 4 Schritten gefunden.', $easteregg->whereAreEasterEggs(4,5));

    }

    /**
     * @test
     */
    public function whereAreEasterEggsThrowsExceptionWhenOutsideGarden(): void
    {
        $easteregg = new EasterEggs('Resources/mikes_garden.txt');
        self::expectException(NotInOurGardenException::class );
        $easteregg->whereAreEasterEggs(-1,3);
    }

}
