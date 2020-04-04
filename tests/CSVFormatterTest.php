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
        yield['Einfacher Text', 'Einfacher Text'];
        yield['Spalte 1|Spalte 2', 'Spalte 1;Spalte 2'];
        yield['Spalte 1|Spalte 2|Spalte 3', 'Spalte 1;Spalte 2;Spalte 3'];
        yield['Spalte 1|Spalte 2|Spalte 3|\n', 'Spalte 1;Spalte 2;Spalte 3\n'];

        yield[
            'Zeile 1|\n' .
            '-------+\n' .
            'Zeile 2|',

            'Zeile 1\n' .
            'Zeile 2'
        ];

        yield[
            'Zeile 1      |\n' .
            '-------------+\n' .
            'Lange Zeile 2|',

            'Zeile 1\n' .
            'Lange Zeile 2'
        ];

        yield[
            'Col1|Col2|Col3|\n' .
            '----+----+----+\n' .
            'ABC |ABC |ABC |',

            'Col1;Col2;Col3\n' .
            'ABC;ABC;ABC'
        ];
        yield[
            'HR1|HR1|\n' .
            '---+---+\n' .
            'DR2|DR2|\n' .
            'DR3|DR3|\n',

            'HR1;HR1\n' .
            'DR2;DR2\n' .
            'DR3;DR3\n'
        ];
    }

    /**
     * @test
     */
    public function showTable(): void
    {
        //self::markTestSkipped('This is our acceptance test for the end.');
        $csvData = 'Name;Strasse;Ort;Alter\nPeter Pan;Am Hang 5;12345 Einsam;42\n' .
                   'Maria Schmitz;Kölner Straße 45;50123 Köln;43\n' .
                   'Paul Meier;Münchener Weg 1;87654 München;65';

        $result = 'Name         |Strasse         |Ort          |Alter|\n' .
                  '-------------+----------------+-------------+-----+\n' .
                  'Peter Pan    |Am Hang 5       |12345 Einsam |42   |\n' .
                  'Maria Schmitz|Kölner Straße 45|50123 Köln   |43   |\n' .
                  'Paul Meier   |Münchener Weg 1 |87654 München|65   |';

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
