<?php


namespace Kata;


class GuessLetters
{
    public const HANGMAN_SYMBOL = '-';
    protected $word2guess;
    protected $result;
    private $word2GuessLength;

    public function __construct(string $word2Guess)
    {
        $this->word2guess = $word2Guess;
        $this->word2GuessLength = strlen($this->word2guess);
        $this->result = str_repeat(self::HANGMAN_SYMBOL, $this->word2GuessLength);
    }

    public function guessLetter(string $guessedLetter): string
    {
        for ($i = 0; $i < $this->word2GuessLength; $i++) {
            $letterAtPos = $this->word2guess[$i];
            if ($this->checkIfLetterIsInside($guessedLetter, $letterAtPos)) {
                $this->result[$i] = $letterAtPos;;
            }
        }
        return $this->result;
    }

    private function checkIfLetterIsInside(string $guessedLetter, string $letterAtPos): bool
    {
        return strtolower($letterAtPos) === strtolower($guessedLetter);
    }
}