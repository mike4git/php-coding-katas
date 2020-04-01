<?php


use Kata\ArabicNumberToRomanCharConverter;
use PHPUnit\Framework\TestCase;

class ArabicNumberToRomanCharConverterTest extends TestCase
{
    private $converter;

    public function sampleTestData(): iterable
    {
        yield['M', 1000];
        yield['MMM', 3000];
        yield['MMMCCC', 3300];
        yield['MMMCCCXXX', 3330];
        yield['MMMCCCXXXIII', 3333];
        yield['V', 5];
        yield['L', 50];
        yield['D', 500];
        yield['IV', 4]; // Subtraktionsregel
        yield['XL', 40];
        yield['CD', 400];
        yield['IX', 9];
        yield['XC', 90];
        yield['CM', 900];
        yield['', 0];
    }

    protected function setUp(): void
    {
        $this->converter = new ArabicNumberToRomanCharConverter();
    }

    /**
     * @test
     */
    public function handleTooBigNumbers(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->converter->convert(4000);
    }

    /**
     * @test
     */
    public function handleNegativeNumbers(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->converter->convert(-1);
    }

    /**
     * @test
     * @dataProvider sampleTestData
     */
    public function convertSampleData(string $romanChar, int $arabicNumber): void
    {
        self::assertSame($romanChar, $this->converter->convert($arabicNumber));
    }

}
