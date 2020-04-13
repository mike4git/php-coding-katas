<?php


use Kata\GuessLetters;
use PHPUnit\Framework\TestCase;

class GuessLettersTest extends TestCase
{
    private $guessLetters;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     * @dataProvider sampleWordsToGuess
     * @param $word2Guess
     * @param $letter
     * @param $result
     */
    public function guessLetter($word2Guess, $letter, $result): void
    {
        $this->guessLetters = new GuessLetters($word2Guess);
        self::assertSame($result, $this->guessLetters->guessLetter($letter));
    }

    public function sampleWordsToGuess()
    {
        yield['Hallo', 'a', '-a---'];
        yield['Hallo', 'H', 'H----'];
        yield['Hallo', 'h', 'H----'];
        yield['Hallo', 'A', '-a---'];
        yield['Hallo', 'l', '--ll-'];
    }

    /**
     * @test
     */
    public function guessMoreLetters(): void
    {
        $this->guessLetters = new GuessLetters('Hallo');
        $this->guessLetters->guessLetter('h');
        $result = $this->guessLetters->guessLetter('a');
        self::assertSame('Ha---', $result);
    }


}
