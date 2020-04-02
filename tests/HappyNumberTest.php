<?php


use Kata\HappyNumber;
use PHPUnit\Framework\TestCase;

class HappyNumberTest extends TestCase
{

    /**
     * @test
     */
    public function isHappy1(): void
    {
        $checker = new HappyNumber();
        self::assertTrue($checker->isHappy(1));
    }

    /**
     * @test
     */
    public function isHappy19(): void
    {
        $checker = new HappyNumber();
        self::assertTrue($checker->isHappy(19));
    }

    /**
     * @test
     */
    public function isUnHappy2(): void
    {
        $checker = new HappyNumber();
        self::assertFalse($checker->isHappy(2));
    }
}
