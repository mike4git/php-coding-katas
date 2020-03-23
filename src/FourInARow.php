<?php
declare(strict_types=1);

namespace Kata;

class FourInARow
{
    private $playerIndex = 1;
    private $boardState = [];

    private $victory = false;

    public function status(): string
    {
        if ($this->victory) {
            return "Spieler " . $this->playerIndex . " hat gewonnen.";
        }
        return "Spieler " . $this->playerIndex . " ist an der Reihe.";
    }

    // Single Level of Abstraction (http://www.principles-wiki.net/principles:single_level_of_abstraction)
    public function makeDraw(int $column): void
    {
        $currentCol = $column - 1;
        if ($this->isInsideBoard($currentCol)) {
            $this->executeDraw($currentCol);
            // already victory
            $rowIndex = count($this->boardState[$currentCol]) - 1;
            $countEqualChips = 0;
            for ($i = $rowIndex; $i >= 0 && ($this->boardState[$currentCol][$i] === $this->playerIndex); $i--) {
                    $countEqualChips++;
            }

            $this->victory = ($countEqualChips >= 4);

            if (!$this->victory) {
                $this->changePlayer();
            }
        }
    }

    /**
     * @param int $column
     * @return bool
     */
    private function isInsideBoard(int $column): bool
    {
        return empty($this->boardState)
            || empty($this->boardState[$column])
            || count($this->boardState[$column]) < 6;
    }

    private function changePlayer(): void
    {
        $this->playerIndex = $this->playerIndex % 2 + 1;
    }

    private function executeDraw(int $column): void
    {
        $this->boardState[$column][] = $this->playerIndex;
    }
}