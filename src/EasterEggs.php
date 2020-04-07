<?php declare(strict_types=1);

namespace Kata;

use Kata\Exception\NotInOurGardenException;

class EasterEggs
{
    private $garden;

    private $eggCount;

    /**
     * @var int
     */
    private $eggsFound;

    /**
     * @var int
     */
    private $steps;

    public function __construct(string $filename)
    {
        $fileContent = $this->hideEggsInGarden($filename);
        $this->countEggs($fileContent);

        $this->eggsFound = 0;
        $this->steps = 0;

    }

    /**
     * @param int $row
     * @param int $column
     * @return string
     * @throws NotInOurGardenException
     */
    public function whereAreEasterEggs(int $row, int $column): string
    {
        $currentRow = $this->calibrateUserInput($row);
        $currentCol = $this->calibrateUserInput($column);

        $this->incrementSteps();

        $result = '';

        if ($this->noEggFound($currentRow, $currentCol)) {
            $eggsFoundAround = $this->lookAround($currentCol, $currentRow, 0);
            $result = 'Es sind ' . $eggsFoundAround . ' Eier in Deiner Nähe';
        } else {
            $this->eggsFound++;
            $result = 'Du hast ein Ei gefunden';
        }

        if ($this->hasFoundAllEggs()) {
            $result = 'Das Kind hat alle ' . $this->eggsFound . ' Eier in ' . $this->steps . ' Schritten gefunden.';
        }

        return $result;
    }

    /**
     * @param int $currentRow
     * @param int $currentCol
     * @return bool
     * @throws NotInOurGardenException
     */
    private function noEggFound(int $currentRow, int $currentCol): bool
    {
        if (!$this->isInGarden($currentRow, $currentCol)) {
            throw new NotInOurGardenException('Du bist nicht mehr im Garten.');
        }

        return $this->garden[$currentRow][$currentCol] !== '*';
    }

    /**
     * @param int $currentCol
     * @param int $currentRow
     * @param int $eggsFoundAround
     * @return int
     * @throws NotInOurGardenException
     */
    protected function lookAround(int $currentCol, int $currentRow, int $eggsFoundAround): int
    {
        // look right
        if (array_key_exists($currentCol + 1, $this->garden[$currentRow]) && !$this->noEggFound(
                $currentRow,
                $currentCol + 1
            )) {
            ++$eggsFoundAround;
        }
        // look left
        if (array_key_exists($currentCol - 1, $this->garden[$currentRow]) && !$this->noEggFound(
                $currentRow,
                $currentCol - 1
            )) {
            ++$eggsFoundAround;
        }
        // look bottom
        if (array_key_exists($currentRow + 1, $this->garden) && !$this->noEggFound($currentRow + 1, $currentCol)) {
            ++$eggsFoundAround;
        }
        //look up
        if (array_key_exists($currentRow - 1, $this->garden) && !$this->noEggFound($currentRow - 1, $currentCol)) {
            ++$eggsFoundAround;
        }

        return $eggsFoundAround;
    }

    /**
     * @param int $currentRow
     * @param int $currentCol
     * @return bool
     */
    private function isInGarden(int $currentRow, int $currentCol): bool
    {
        return (array_key_exists($currentRow, $this->garden) && array_key_exists(
                $currentCol,
                $this->garden[$currentRow]
            ));
    }

    /**
     * @param string $filename
     * @return false|string
     */
    private function hideEggsInGarden(string $filename)
    {
        $fileContent = file_get_contents('Resources/' . $filename);
        foreach (explode(PHP_EOL, $fileContent) as $row) {
            $this->garden[] = explode(' ', $row);
        }
        return $fileContent;
    }

    /**
     * @param string $fileContent
     */
    private function countEggs(string $fileContent): void
    {
        $this->eggCount = substr_count($fileContent, '*');
    }

    /**
     * @param int $row
     * @return int
     */
    private function calibrateUserInput(int $row): int
    {
        return $row - 1;
    }

    private function incrementSteps(): void
    {
        $this->steps++;
    }

    /**
     * @return bool
     */
    private function hasFoundAllEggs(): bool
    {
        return $this->eggsFound === $this->eggCount;
    }
}