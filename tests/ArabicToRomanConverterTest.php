<?php declare(strict_types=1);

use Kata\ArabicToRomanConverter;
use PHPUnit\Framework\TestCase;

class ArabicToRomanConverterTest extends TestCase
{
    /**
     * @var ArabicToRomanConverter
     */
    private $converter;

    public function converterDataProvider(): iterable
    {
        yield 'convert 1' => ['I', 1];
        yield 'convert 2' => ['II', 2];
        yield 'convert 4' => ['IV', 4];
        yield 'convert 5' => ['V', 5];
        yield 'convert 7' => ['VII', 7];
        yield 'convert 23' => ['XXIII', 23];
        yield 'convert 1456' => ['MCDLVI', 1456];
    }

    protected function setUp(): void
    {
        $this->converter = new ArabicToRomanConverter();
    }

    /**
     * @test
     * @dataProvider converterDataProvider
     * @param string $expected
     * @param int    $number
     */
    public function convertOnInput(string $expected, int $number): void
    {
        self::assertSame($expected, $this->converter->convert($number));
    }
}
