<?php declare(strict_types=1);

namespace Matrix;

class TwoDimensionalMatrixRotator implements Rotatable
{
    private $matrix;
    private $numRows;
    private $numCols;
    private $rotation;

    public function __construct(array $matrix, Rotation $rotation)
    {
        $this->matrix = $matrix;
        $this->rotation = $rotation;
        $this->numRows = \count($matrix);
        $this->numCols = \count(current($this->matrix));
    }

    public function rotate(): array
    {
        $result = [];
        $numLayers = $this->numLayers();

        for ($i = 0, $nr = $this->numRows, $nc = $this->numCols; $i < $numLayers; ++$i, $nr -= 2, $nc -= 2) {
            $numEffectiveRotations = $this->rotation->getNumberOfRotations() % (($nr + $nc - 2) << 1);
            $layerIndices = $this->getLayerIndices($i, $nr, $nc);

            $numIndices = \count($layerIndices);

            foreach ($layerIndices as $key => $layerIndex) {
                $rotatedIndex = $this->getMappedIndexAfterRotation($key, $numEffectiveRotations, $numIndices);

                $result[$layerIndices[$rotatedIndex][0]][$layerIndices[$rotatedIndex][1]] = $this->matrix[$layerIndex[0]][$layerIndex[1]];
            }
        }

        return self::normalize($result, $this->numRows, $this->numCols);
    }

    private function getLayerIndices(int $offset, int $numRows, int $numCols): array {
        $indices = [];
        $nc = $numCols - 1;
        $nr = $numRows - 1;

        //Now $i = $offset, $j = $offset
        for ($j = $offset, $i = $offset; $i < $offset + $nr; ++$i) {
            $indices[] = [$i, $j];
        }

        //Now $i = $offset + $nr, $j = $offset
        for (; $j < $nc + $offset; ++$j) {
            $indices[] = [$i, $j];
        }

        //Now $i = $offset + $nr, $j = $nc + $offset
        for (; $i > $offset; --$i) {
            $indices[] = [$i, $j];
        }

        //Now $i = $offset, $j = $nc + $offset
        for (; $j > $offset; --$j) {
            $indices[] = [$i, $j];
        }

        return $indices;
    }

    private function numLayers(): int
    {
        return min($this->numRows, $this->numCols) >> 1;
    }

    private static function normalize(array $matrix, int $numRows, int $numCols): array
    {
        $result = [];

        for ($i = 0; $i < $numRows; ++$i) {
            for ($j = 0; $j < $numCols; ++$j) {
                $result[$i][$j] = $matrix[$i][$j];
            }
        }

        return $result;
    }

    private function getMappedIndexAfterRotation(int $key, int $numEffectiveRotations, int $numIndices): int
    {
        $numRotation = Rotation::DIRECTION_COUNTERCLOCKWISE === $this->rotation->getDirection()
            ? $numEffectiveRotations
            : -$numEffectiveRotations;

        return ($key + $numRotation + $numIndices) % $numIndices;
    }
}