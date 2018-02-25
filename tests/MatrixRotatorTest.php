<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Matrix\Rotator;
use Matrix\Rotation;

require 'MatrixIterator.php';

class MatrixRotatorTest extends TestCase
{
    private const TEST_DATA_MIN_INDEX = 0;
    private const TEST_DATA_MAX_INDEX = 12;
    private const TEST_DATA_BASE_PATH = __DIR__ . '/_data/';

    /**
     * @param Rotation $rotation
     * @param int[] $input
     * @param int[] $expected
     * @dataProvider readMatrixDataFromFileForCounterclockwiseRotation
     */
    public function test_matrix_rotator_can_read_data_from_from_file_and_rotate_matrices_counterclockwise(Rotation $rotation, array $input, array $expected): void
    {
        $this->assertEquals($expected, (new Rotator($input, $rotation))->rotate());
    }

    /**
     * @param Rotation $rotation
     * @param int[] $input
     * @param int[] $expected
     * @dataProvider readMatrixDataFromFileForClockwiseRotation
     */
    public function test_matrix_rotator_can_read_data_from_from_file_and_rotate_matrices_clockwise(Rotation $rotation, array $input, array $expected): void
    {
        $this->assertEquals($expected, (new Rotator($input, $rotation))->rotate());
    }

    public function test_with_invalid_rotation_throws_exception(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Rotation(2, 3);
    }
    
    public function readMatrixDataFromFileForCounterclockwiseRotation(): \Iterator
    {
        return new MatrixIterator(
            self::TEST_DATA_BASE_PATH,
            self::TEST_DATA_MIN_INDEX,
            self::TEST_DATA_MAX_INDEX,
            Rotation::DIRECTION_COUNTERCLOCKWISE
        );
    }

    public function readMatrixDataFromFileForClockwiseRotation(): \Iterator
    {
        return new MatrixIterator(
            self::TEST_DATA_BASE_PATH,
            self::TEST_DATA_MIN_INDEX,
            self::TEST_DATA_MAX_INDEX,
            Rotation::DIRECTION_CLOCKWISE
        );
    }
}
