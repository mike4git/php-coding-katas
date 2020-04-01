<?php

namespace Kata\Tests;

use Kata\FizzBuzz;
use PHPUnit\Framework\TestCase;

class FizzBuzzTest extends TestCase
{

    /**
     * @test
     * @dataProvider provideTestData
     */
    public function returnOneWhenOneIsGiven(int $number, string $resultString): void
    {
        self::markTestSkipped('Not necessary');
        $fizzBuzz = new FizzBuzz();
        self::assertSame($resultString, $fizzBuzz->process($number));
    }

    public function provideTestData(): iterable
    {
        yield [1, '1'];
        yield [2, '2'];
        yield [3, 'Fizz'];
        yield [4, '4'];
        yield [5, 'Buzz'];
        yield [6, 'Fizz'];
        yield [10, 'Buzz'];
        yield [15, 'FizzBuzz'];
        yield [30, 'FizzBuzz'];
    }
}
