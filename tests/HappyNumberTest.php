<?php


use Kata\HappyNumber;
use PHPUnit\Framework\TestCase;

class HappyNumberTest extends TestCase
{
    private $checker;

    public function happyNumbersData()
    {
        yield [1, true];
        yield [2, false];
        yield [3, false];
        yield [7, true];
        yield [10, true];
        yield [19, true];
        yield [22, false];
    }


    protected function setUp(): void
    {
        $this->checker = new HappyNumber();
        parent::setUp();
    }

    /**
     * @test
     * @dataProvider happyNumbersData
     */
    public function isHappy(int $number, bool $isHappy): void
    {
        self::assertSame($isHappy, $this->checker->isHappy($number));
    }

    /**
     * All happy numbers
     * from https://de.wikipedia.org/wiki/Fr%C3%B6hliche_Zahl
     * until 1000
     * @test
     */
    public function countOfHappyNumbersUntil1000(): void
    {
        $maximumNumber = 1000;
        $expectedCount = 143;
        $actualCount = 0;

        for ($number = 1; $number <= $maximumNumber; $number++) {
            if ($this->checker->isHappy($number)) {
                $actualCount++;
            }
        }
        self::assertSame($expectedCount, $actualCount);
    }

}
