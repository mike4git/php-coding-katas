<?php


namespace Kata;


use Kata\Exception\NotInOurGardenException;

class EasterEggs
{
    const UP = -1;
    const DOWN = 1;
    const RIGHT = 1;
    const LEFT = -1;
    private array $garden;

    private int $eggsCount;

    private int $eggsFound = 0;
    private int $steps = 0;

    public function __construct(string $filename)
    {
        $content = file_get_contents($filename);
        $content = str_replace("\r", '', $content);
        $this->eggsCount = substr_count($content, '*');
        $gardenRows = explode(PHP_EOL, $content);
        foreach ($gardenRows as $row) {
            $this->garden[] = explode(' ', $row);
        }
    }

    /**
     * @throws NotInOurGardenException
     */
    public function whereAreEasterEggs(int $row, int $column): string
    {
        list($currentCol, $currentRow) =
            $this->validateUserInput($row, $column);

        $this->countOneMoreStep();

        if ($this->eggFound($currentRow, $currentCol)) {

            $this->countOneMoreEggFound();

            if ($this->allEggsFound($this->eggsFound)) {
                $return = $this->finishedEggSearchStats();
            } else {
                $return = $this->eggFoundMessage();
            }
        } else {
            $return = $this->noEggFoundHint($currentRow, $currentCol);
        }

        return $return;
    }


    private function eggFound(int $row, int $column): bool
    {
        return $this->garden[$row][$column] === '*';
    }

    private function eggNearbyFound(
        int $row, int $column,
        int $rowDirection, int $columnDirection
    ): bool
    {
        if ($this->fieldDoesNotExist(
            $row + $rowDirection,
            $column + $columnDirection)
        )
            return false;

        return $this->eggFound(
            $row + $rowDirection,
            $column + $columnDirection
        );
    }


    private function allEggsFound(int $eggsFound): bool
    {
        return $eggsFound === $this->eggsCount;
    }


    private function lookAroundAndCount(int $row, int $column): int
    {
        $eggsNearBy = 0;
        for ($rowDirection = self::UP;
             $rowDirection <= self::DOWN;
             $rowDirection++) {

            for ($columnDirection = self::LEFT;
                 $columnDirection <= self::RIGHT;
                 $columnDirection++) {

                if ($this->eggNearbyFound(
                    $row, $column,
                    $rowDirection, $columnDirection)
                ) {
                    $eggsNearBy++;
                }
            }
        }
        return $eggsNearBy;
    }

    private function fieldDoesNotExist(int $row, int $column): bool
    {
        if ($this->rowDoesNotExist($row)
            || $this->columnDoesNotExist($row, $column))
            return true;
        return false;
    }

    private function rowDoesNotExist(int $row): bool
    {
        return !array_key_exists($row, $this->garden);
    }

    private function columnDoesNotExist(int $row, int $column): bool
    {
        return !array_key_exists($column, $this->garden[$row]);
    }

    /**
     * @throws NotInOurGardenException
     */
    private function validateUserInput(int $row, int $column): array
    {
        $currentCol = $column - 1;
        $currentRow = $row - 1;

        if ($this->fieldDoesNotExist($currentRow, $currentCol)) {
            throw new NotInOurGardenException('This is not in our garden.');
        }

        return array($currentCol, $currentRow);
    }

    private function countOneMoreStep(): void
    {
        $this->steps++;
    }

    private function countOneMoreEggFound(): void
    {
        $this->eggsFound++;
    }

    /**
     * @return string
     */
    private function finishedEggSearchStats(): string
    {
        return 'Das Kind hat alle ' .
            $this->eggsCount .
            ' Eier in ' .
            $this->steps .
            ' Schritten gefunden.';
    }

    /**
     * @return string
     */
    private function eggFoundMessage(): string
    {
        return 'Du hast ein Ei gefunden.';
    }

    /**
     * @param $currentRow
     * @param $currentCol
     * @return string
     */
    private function noEggFoundHint($currentRow, $currentCol): string
    {
        return 'Du hast ' .
            $this->lookAroundAndCount($currentRow, $currentCol) .
            ' Eier in Deiner Nähe.';
    }
}