<?php declare(strict_types=1);

namespace Kata;

class CSVFormatter
{
    const NEWLINE = '\n';
    const CSV_SEPARATOR = ';';
    const PIPE = '|';
    const TABLE_LINE_SEPARATOR = '-';
    const TABLE_LINE_END = '+';

    public function showTable(string $csvLines): string
    {
        $linesIterable = $this->splitLines($csvLines);

        $resultArr = [];
        foreach ($linesIterable as $key => $line) {
            $resultArr[$key] = $this->replaceString($line, self::CSV_SEPARATOR, self::PIPE);
        }

        if (count($linesIterable) === 1) {
            return $resultArr[0];
        } elseif (empty($resultArr[1])) {
            return $resultArr[0] . self::PIPE . self::NEWLINE;
        }

        $firstLine = array_slice($resultArr, 0, 1);
        $restLines = array_slice($resultArr, 1);

        $result = [];

        $firstLine[0] .= self::PIPE;

        $result[] = implode($firstLine);
        $result[] = str_repeat('---+', substr_count($firstLine[0], self::PIPE));
        $result[] = implode(self::PIPE . self::NEWLINE, $restLines);

        return implode(self::NEWLINE, $result);
    }

    private function replaceString(string $csvLines, string $needle, string $replace)
    {
        $result = $csvLines;
        $pos = strpos($csvLines, $needle);
        if ($pos !== false) {
            $result = str_replace($needle, $replace, $csvLines);
        }

        return $result;
    }

    /**
     * @param     $result
     * @param int $pos
     * @return string
     */
    private function determineSeparationLine($result, int $pos): string
    {
        // ermittle Teilstring bis zu $pos
        $firstline = substr($result, 0, $pos + 1);
        // zähle wie oft | in Teilstring ist
        $pipeCount = substr_count($firstline, self::PIPE);

        // setze Counter für ---+ auf die oben ermittelte Anzahl
        return str_repeat(str_repeat(self::TABLE_LINE_SEPARATOR, 3) . self::TABLE_LINE_END, $pipeCount);
    }

    private function splitLines(string $csvFile): array
    {
        return explode(self::NEWLINE, $csvFile);
    }
}