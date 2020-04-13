<?php


use Kata\HangmanDrawer;
use PHPUnit\Framework\TestCase;

class HangmanDrawerTest extends TestCase
{

    /**
     * @test
     */
    public function guessWrongLetter(): void
    {
        $hangmanDrawer = new HangmanDrawer('Hallo');
        self::assertSame(HangmanDrawer::HANGMANPICS[0], $hangmanDrawer->guessLetter('X'));
    }

    /**
     * @test
     */
    public function guessTwoWrongLetters(): void
    {
        $hangmanDrawer = new HangmanDrawer('Hallo');
        $hangmanDrawer->guessLetter('X');
        self::assertSame(HangmanDrawer::HANGMANPICS[1], $hangmanDrawer->guessLetter('X'));
    }

    /**
     * @test
     */
    public function lostGame(): void
    {
        $hangmanDrawer = new HangmanDrawer('Hallo');
        $hangmanDrawer->guessLetter('E');
        $hangmanDrawer->guessLetter('N');
        $hangmanDrawer->guessLetter('R');
        $hangmanDrawer->guessLetter('S');
        $hangmanDrawer->guessLetter('T');
        $hangmanDrawer->guessLetter('M');
        $hangmanDrawer->guessLetter('Q');
        self::assertSame(HangmanDrawer::HANGMANPICS[6], $hangmanDrawer->guessLetter('X'));
    }

    /**
     * @test
     */
    public function guessCorrectLetter(): void
    {
        $hangmanDrawer = new HangmanDrawer('Hallo');
        self::assertSame('----o', $hangmanDrawer->guessLetter('o'));
    }
}
