<?php declare(strict_types=1);

use Kata\CSVFormatter;
use PHPUnit\Framework\TestCase;

class CSVFormatterTest extends TestCase
{
    private $csvFormatter;

    protected function setUp(): void
    {
        $this->csvFormatter = new CSVFormatter();
    }

    public function sampleTestData(): iterable
    {
        yield['balala', 'balala'];
        yield['Bla|Bla', 'Bla;Bla'];
        yield['Bla|Bla|Bla', 'Bla;Bla;Bla'];
        yield['Bla|Bla|Bla|\n', 'Bla;Bla;Bla\n'];
        yield['Bla|\n---+\nABC|\n', 'Bla\nABC\n'];
        yield['Bla|Bla|Bla|\n---+---+---+\nABC|ABC|ABC|\n', 'Bla;Bla;Bla\nABC;ABC;ABC\n'];
        yield['HR1|HR1|\n---+---+\nDR2|DR2|\nDR3|DR3|\n', 'HR1;HR1\nDR2;DR2\nDR3;DR3\n'];
        yield['AB|ABC|\n--+---+\nAB|ABC|\n', 'AB;ABC\nAB;ABC\n'];
    }

    /**
     * @test
     */
    public function showTable(): void
    {
        self::markTestSkipped('This is our acceptance test for the end.');
        $csvData = 'Name;Strasse;Ort;Alter\nPeter Pan;Am Hang 5;12345 Einsam;42' .
            '\nMaria Schmitz;Kölner Straße 45;50123 Köln;43\nPaul Meier;Münchener Weg 1;87654 München;65';

        $result = 'Name         |Strasse         |Ort          |Alter|\n' .
                  '-------------+----------------+-------------+-----+\n' .
                  'Peter Pan    |Am Hang 5       |12345 Einsam |42   |\n' .
                  'Maria Schmitz|Kölner Straße 45|50123 Köln   |43   |\n' .
                  'Paul Meier   |Münchener Weg 1 |87654 München|65   |\n';

        self::assertSame($result, $this->csvFormatter->showTable($csvData));
    }

    /**
     * @test
     * @dataProvider sampleTestData
     * @param String $output
     * @param String $input
     */
    public function showTableGiveBackTwoSeparatedWordsWhenStringWithSemicolonIsGiven(String $output, String $input): void
    {
        self::assertSame($output, $this->csvFormatter->showTable($input));
    }
}
