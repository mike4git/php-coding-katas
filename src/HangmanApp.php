<?php

namespace Kata;

echo('Lass uns Hangman spielen');

$hangman = new HangmanDrawer('Idiosynkrasie');
while(true)
{
    $guessedLetter = stream_get_contents(STDIN, 1);
    echo($hangman->guessLetter($guessedLetter).PHP_EOL);
}
