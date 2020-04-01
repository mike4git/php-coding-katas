<?php declare(strict_types=1);

use Kata\ArabicToRomanConverter;
use PHPUnit\Framework\TestCase;

class ArabicToRomanConverterTest extends TestCase
{
    /**
     * @var ArabicToRomanConverter
     */
    private $converter;

    protected function setUp(): void
    {
        $this->converter = new ArabicToRomanConverter();
    }

    /**
     * @test
     * @dataProvider converterDataProvider
     */
    public function convertOnInput(string $expected, int $number)
    {
        self::assertSame($expected, $this->converter->convert($number));
    }

    public function converterDataProvider(): iterable
    {
        yield ['', 0];
        yield ['I', 1];
        yield ['II', 2];
        yield ['IV', 4];
        yield ['V', 5];
        yield ['VII', 7];
        yield ['XXIII', 23];
    }
}
