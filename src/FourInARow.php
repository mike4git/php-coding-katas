<?php
declare(strict_types=1);

namespace Kata;

class FourInARow
{
    private $playerIndex = 1;
    private $boardState = [];

    private $victory = false;

    public function __construct()
    {
        for($i = 0; $i < 7;$i++) {
            $this->boardState[] = [];
            for($j=0; $j<6;$j++) {
                $this->boardState[$i][] = 0;
            }
        }
    }

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
        $currentRow = 0;
        while($this->isInsideBoard($currentCol, $currentRow) && $this->isFieldOccupied($currentCol, $currentRow)) {
            $currentRow++;
        }

        if ($this->isInsideBoard($currentCol, $currentRow)) {
            $this->executeDraw($currentCol, $currentRow);
            // already victory
            $this->victory = $this->checkVerticalVictory($currentCol, $currentRow)
                || $this-> checkHorizontalVictory($currentCol, $currentRow)
                || $this-> checkBackSlashVictory($currentCol, $currentRow)
                || $this-> checkSlashVictory($currentCol, $currentRow);

            if (!$this->victory) {
                $this->changePlayer();
            }
        }
    }

    /**
     * @param int $column
     * @return bool
     */
    private function isInsideBoard(int $column, int $row): bool
    {
       return $column >= 0 && $column < 7 && $row >= 0 && $row < 6;
    }

    private function changePlayer(): void
    {
        $this->playerIndex = $this->playerIndex % 2 + 1;
    }

    private function executeDraw(int $column, int $row): void
    {
        $this->boardState[$column][$row] = $this->playerIndex;
    }

    /**
     * @param int $currentCol
     */
    private function checkVerticalVictory(int $currentCol, int $currentRow): bool
    {
        $countSameChips = 0;
        // guck nach unten
        for ($i = $currentRow; $this->isInsideBoard($currentCol, $i) && $this->isChipOfCurrentPlayer($currentCol, $i); $i--) {
            $countSameChips++;
        }

        return $countSameChips >= 4;
    }

    /**
     * @param int $currentCol
     */
    private function checkHorizontalVictory(int $currentCol, int $currentRow): bool
    {
        $countSameChips = 0;
        // guck nach links
        for ($i = $currentCol; $this->isInsideBoard($i, $currentRow) && $this->isChipOfCurrentPlayer($i, $currentRow); $i--) {
            $countSameChips++;
        }
        // guck nach rechts
        for ($i = $currentCol+1; $this->isInsideBoard($i, $currentRow) && $this->isChipOfCurrentPlayer($i, $currentRow); $i++) {
            $countSameChips++;
        }

        return $countSameChips >= 4;
    }

    private function checkBackSlashVictory(int $currentCol, int $currentRow): bool
    {
        $countSameChips = 0;
        for ($i = $currentRow, $j= $currentCol; $this->isInsideBoard($j, $i) && $this->isChipOfCurrentPlayer($j, $i); $i--,$j++) {
            $countSameChips++;
        }
        for ($i = $currentRow+1, $j= $currentCol-1; $this->isInsideBoard($j, $i) && $this->isChipOfCurrentPlayer($j, $i); $i++,$j--) {
            $countSameChips++;
        }

        return $countSameChips >= 4;
    }

    private function checkSlashVictory(int $currentCol, int $currentRow): bool
    {
        $countSameChips = 0;
        for ($i = $currentRow, $j= $currentCol; $this->isInsideBoard($j, $i) && $this->isChipOfCurrentPlayer($j, $i); $i++,$j++) {
            $countSameChips++;
        }
        for ($i = $currentRow-1, $j= $currentCol-1; $this->isInsideBoard($j, $i) && $this->isChipOfCurrentPlayer($j, $i); $i--,$j--) {
            $countSameChips++;
        }

        return $countSameChips >= 4;
    }



    /**
     * @param int $col
     * @param int $row
     * @return bool
     */
    private function isChipOfCurrentPlayer(int $col, int $row): bool
    {
        return ($this->boardState[$col][$row] === $this->playerIndex);
    }

    /**
     * @param int $currentCol
     * @param int $currentRow
     * @return bool
     */
    private function isFieldOccupied(int $currentCol, int $currentRow): bool
    {
        return $this->boardState[$currentCol][$currentRow] != 0;
    }
}