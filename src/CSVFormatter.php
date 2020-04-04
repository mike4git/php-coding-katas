<?php declare(strict_types=1);

namespace Kata;

class CSVFormatter
{
    private const NEWLINE = '\n';
    private const CSV_SEPARATOR = ';';
    private const PIPE = '|';
    private const TABLE_LINE_SEPARATOR = '-';
    private const TABLE_LINE_END = '+';

    private $words;
    private $lengthOfColumns;
    private $numberOfLines;
    private $numberOfColumns;

    public function showTable(string $csvLines): string
    {
        $linesIterable = $this->splitLines($csvLines);

        $this->words = $this->splitLinesIntoWords($linesIterable);

        $this->initalizeStats();

        $this->fillUpAllWordsToMaxLength();

        $headerLine = $this->concatWordsWithPipe(0);

        if ($this->isSingleLine()) {
            $tableAsString = $headerLine;
        } elseif ($this->isSingleLineWithNewline($linesIterable)) {
            $tableAsString = $headerLine . self::PIPE . self::NEWLINE;
        } else {
            $header = [];
            $header[] = $headerLine . self::PIPE;
            $header[] = $this->determineHeaderSeparationLine();
            $tableAsString = $this->returnTableAsString($header);
        }

        return $tableAsString;
    }

    private function splitLines(string $csvFile): array
    {
        return explode(self::NEWLINE, $csvFile);
    }

    private function determineHeaderSeparationLine(): string
    {
        $separationLine = '';
        for ($i = 0; $i < $this->numberOfColumns; $i++) {
            if ($this->lengthOfColumns[$i] > 0) {
                $separationLine .= str_repeat(self::TABLE_LINE_SEPARATOR, $this->lengthOfColumns[$i]);
                $separationLine .= self::TABLE_LINE_END;
            }
        }

        return $separationLine;
    }

    private function determineMaximumWordLength(int $numberOfLines, int $column)
    {
        $max = 0;

        for ($row = 0; $row < $numberOfLines; $row++) {
            if (array_key_exists($column, $this->words[$row])
                && $max < mb_strlen($this->words[$row][$column], "utf-8")) {
                $max = mb_strlen($this->words[$row][$column], "utf-8");
            }
        }
        return $max;
    }

    /**
     * @param array $linesIterable
     */
    private function splitLinesIntoWords(array $linesIterable): array
    {
        $words = [];
        foreach ($linesIterable as $line) {
            $words[] = explode(self::CSV_SEPARATOR, $line);
        }

        return $words;
    }

    private function fillUpAllWordsToMaxLength()
    {
        for ($row = 0; $row < $this->numberOfLines; $row++) {
            if (strlen($this->words[$row][0]) > 0) {
                for ($col = 0; $col < $this->numberOfColumns; $col++) {
                    $this->words[$row][$col] = $this->mb_str_pad($this->words[$row][$col], $this->lengthOfColumns[$col]);
                }
            }
        }
    }

    private function mb_str_pad(
        string $input,
        int $pad_length,
        string $pad_string = ' ',
        int $pad_style = STR_PAD_RIGHT,
        string $encoding = 'UTF-8'
    )

    {

        $pad_length = $pad_length - mb_strlen($input, $encoding) + strlen($input);

        return str_pad
        (
            $input,
            $pad_length,
            $pad_string,
            $pad_style
        );
    }

    private function initalizeStats(): void
    {
        $this->lengthOfColumns = [];

        $this->numberOfLines = count($this->words);
        $this->numberOfColumns = count($this->words[0]);

        for ($column = 0; $column < $this->numberOfColumns; $column++) {
            $this->lengthOfColumns[] = $this->determineMaximumWordLength($this->numberOfLines, $column);
        }
    }

    /**
     * @return bool
     */
    private function isSingleLine(): bool
    {
        return $this->numberOfLines === 1;
    }

    /**
     * @param array $linesIterable
     * @return bool
     */
    private function isSingleLineWithNewline(array $linesIterable): bool
    {
        return $this->numberOfLines === 2 && empty($linesIterable[1]);
    }

    /**
     * @param $row
     * @return string
     */
    private function concatWordsWithPipe($row): string
    {
        return implode(self::PIPE, $this->words[$row]);
    }

    /**
     * @param int $row
     * @return bool
     */
    private function isEmptyLine(int $row): bool
    {
        return strlen($this->words[$row][0]) > 0;
    }

    /**
     * @return array
     */
    private function determineDataLines(): array
    {
        $result = [];
        $dataLines = [];
        for ($row = 1; $row < $this->numberOfLines; $row++) {
            if ($this->isEmptyLine($row)) {
                $dataLines[] = $this->concatWordsWithPipe($row) . self::PIPE;
            } else {
                $dataLines[] = $this->concatWordsWithPipe($row);
            }
        }

        foreach ($dataLines as $dataLine) {
            $result[] = $dataLine;
        }
        return $result;
    }

    /**
     * @param array $header
     * @return string
     */
    private function returnTableAsString(array $header): string
    {
        return implode(self::NEWLINE, array_merge($header, $this->determineDataLines()));
    }

}