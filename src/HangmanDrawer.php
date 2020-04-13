<?php

namespace Kata;

class HangmanDrawer extends GuessLetters
{
    private $currentIndex = -1;

    public function __construct(string $word2Guess)
    {
        parent::__construct($word2Guess);
    }

    public function guessLetter(string $guessedLetter): string
    {
        $oldResult = $this->result;
        $newResult = parent::guessLetter($guessedLetter);
        if ($oldResult === $newResult) {
            if ($this->currentIndex < count(self::HANGMANPICS) - 1)
                $this->currentIndex++;
            return self::HANGMANPICS[$this->currentIndex];
        } else {
            return $this->result;
        }
    }

    public const HANGMANPICS = ['
  +---+
  |   |
      |
      |
      |
      |
=========', '
  +---+
  |   |
  O   |
      |
      |
      |
=========', '
  +---+
  |   |
  O   |
  |   |
      |
      |
=========', '
  +---+
  |   |
  O   |
 /|   |
      |
      |
=========', '
  +---+
  |   |
  O   |
 /|\  |
      |
      |
=========', '
  +---+
  |   |
  O   |
 /|\  |
 /    |
      |
=========', '
  +---+
  |   |
  O   |
 /|\  |
 / \  |
      |
========='];
}