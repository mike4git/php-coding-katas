<?php
declare(strict_types=1);

namespace Kata;

class FourInARow
{
    const NUMBER_OF_COLUMNS = 7;
    const NUMBER_OF_ROWS = 6;
    private $playerIndex = 1;
    private $boardState = [];

    private $victory = false;
    private $tie = false;

    private $outputs = [
        [0, "Das Spiel endet Unentschieden."]
    ];

    private $numberOfDraws = 0;

    public function __construct()
    {
        for($i = 0; $i < self::NUMBER_OF_COLUMNS; $i++) {
            $this->boardState[] = [];
            for($j=0; $j< self::NUMBER_OF_ROWS; $j++) {
                $this->boardState[$i][] = 0;
            }
        }
    }

    public function status(): string
    {
        if ($this->tie) {
            return $this->outputs[0][1];
        }
        if ($this->victory) {
            return "Spieler " . $this->playerIndex . " hat gewonnen.";
        }
        return "Spieler " . $this->playerIndex . " ist an der Reihe.";
    }

    // Single Level of Abstraction (http://www.principles-wiki.net/principles:single_level_of_abstraction)
    public function makeDraw(int $column): void
    {
        $currentCol = $column - 1;
        $currentRow = $this->findCurrentRow($currentCol);

        if ($this->isInsideBoard($currentCol, $currentRow)) {
            $this->executeDraw($currentCol, $currentRow);

            $this->victory = $this->checkVictory($currentCol, $currentRow);
            $this->tie = $this->checkTiedGame();

            if ($this->hasGameNotFinished()) {
                $this->changePlayer();
            }
        }
    }

    private function changePlayer(): void
    {
        $this->playerIndex = $this->playerIndex % 2 + 1;
    }

    private function executeDraw(int $column, int $row): void
    {
        $this->boardState[$column][$row] = $this->playerIndex;
        $this->numberOfDraws++;
    }

    private function isChipOfCurrentPlayer(int $col, int $row): bool
    {
        return ($this->boardState[$col][$row] === $this->playerIndex);
    }

    private function isInsideBoard(int $column, int $row): bool
    {
       return $column >= 0 && $column < self::NUMBER_OF_COLUMNS && $row >= 0 && $row < self::NUMBER_OF_ROWS;
    }

    private function isFieldOccupied(int $currentCol, int $currentRow): bool
    {
        return $this->boardState[$currentCol][$currentRow] !== 0;
    }

    private function findCurrentRow(int $currentCol): int
    {
        $currentRow = 0;
        while ($this->isInsideBoard($currentCol, $currentRow) && $this->isFieldOccupied($currentCol, $currentRow)) {
            $currentRow++;
        }
        return $currentRow;
    }

    private function checkVictory(int $currentCol, int $currentRow): bool
    {
        return $this->checkVerticalVictory($currentCol, $currentRow)
            || $this->checkHorizontalVictory($currentCol, $currentRow)
            || $this->checkBackSlashVictory($currentCol, $currentRow)
            || $this->checkSlashVictory($currentCol, $currentRow);
    }

    private function checkVerticalVictory(int $currentCol, int $currentRow): bool
    {
        return $this->checkVictoryWithDirection($currentCol, $currentRow, 0,1);
    }

    private function checkHorizontalVictory(int $currentCol, int $currentRow): bool
    {
        return $this->checkVictoryWithDirection($currentCol, $currentRow, 1,0);
    }

    private function checkBackSlashVictory(int $currentCol, int $currentRow): bool
    {
        return $this->checkVictoryWithDirection($currentCol,$currentRow,-1,1);
    }

    private function checkSlashVictory(int $currentCol, int $currentRow): bool
    {
        return $this->checkVictoryWithDirection($currentCol,$currentRow,1,1);
    }

    private function checkVictoryWithDirection(int $currentCol, int $currentRow, int $deltaCol, int $deltaRow): bool
    {
        $countSameChips = 0;
        for ($i = $currentRow, $j= $currentCol; $this->isInsideBoard($j, $i) && $this->isChipOfCurrentPlayer($j, $i); $i= $i+$deltaRow,$j=$j+$deltaCol) {
            $countSameChips++;
        }
        for ($i = $currentRow-$deltaRow, $j= $currentCol-$deltaCol; $this->isInsideBoard($j, $i) && $this->isChipOfCurrentPlayer($j, $i); $i= $i-$deltaRow,$j=$j-$deltaCol) {
            $countSameChips++;
        }

        return $countSameChips >= 4;
    }

    private function checkTiedGame(): bool
    {
        return $this->numberOfDraws === self::NUMBER_OF_ROWS * self::NUMBER_OF_COLUMNS;
    }

    private function hasGameNotFinished(): bool
    {
        return !$this->victory && !$this->tie;
    }

}