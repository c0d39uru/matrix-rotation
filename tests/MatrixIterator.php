<?php declare(strict_types=1);

use Matrix\Rotation;

class MatrixIterator implements \Iterator
{
    private $basePath;
    private $minIndex;
    private $maxIndex;
    private $direction;

    private $currentTestCaseIndex;

    public function __construct(string $basePath, int $minIndex, int $maxIndex, int $direction)
    {
        $this->basePath = $basePath;
        $this->minIndex = $minIndex;
        $this->maxIndex = $maxIndex;
        $this->direction = $direction;

        $this->currentTestCaseIndex = $this->minIndex;
    }

    public function __destruct()
    {
        unset($this->basePath, $this->minIndex, $this->maxIndex, $this->direction, $this->currentTestCaseIndex);
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function rewind(): void
    {
        $this->currentTestCaseIndex = $this->minIndex;
    }

    public function valid(): bool
    {
        return $this->minIndex <= $this->currentTestCaseIndex && $this->currentTestCaseIndex <= $this->maxIndex;
    }

    public function key(): int
    {
        return $this->currentTestCaseIndex;
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function next(): void
    {
        ++$this->currentTestCaseIndex;
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function current(): array
    {
        $inputFileName = $this->basePath . sprintf('input%02d.txt', $this->currentTestCaseIndex);
        $outputFileName = $this->basePath . sprintf('output%02d.txt', $this->currentTestCaseIndex);

        $inputParams = $this->readMatrixFromFile($inputFileName, $this->direction, true);
        $outputParams = $this->readMatrixFromFile($outputFileName, $this->direction, false);

        return Rotation::DIRECTION_COUNTERCLOCKWISE === $this->direction
            ?  [
                $inputParams['rotation'],
                $inputParams['matrix'],
                $outputParams['matrix'],
            ] : [
                $inputParams['rotation'],
                $outputParams['matrix'],
                $inputParams['matrix'],
            ];
    }

    /**
     * @param string $fileName
     * @param int $direction
     * @param bool $isInput
     * @return array
     * @throws \InvalidArgumentException
     */
    private function readMatrixFromFile(string $fileName, int $direction, bool $isInput = false): array
    {
        $numRotations = -1;

        $fp = fopen($fileName, 'r');

        if ($isInput) {
            [$numRows, $numCols, $numRotations] = explode(' ', trim(fgets($fp)));
        }

        for ($matrix = []; !feof($fp);) {
            $matrix[] = array_map(function($value) {
                    return (int)$value;
                },
                explode(' ', trim(fgets($fp)))
            );
        }

        fclose($fp);

        return [
            'matrix' => $matrix,
            'rotation' => new Rotation($direction, (int)$numRotations),
        ];
    }
}