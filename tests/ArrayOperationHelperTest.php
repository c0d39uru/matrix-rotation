<?php

use Matrix\Rotation;
use PHPUnit\Framework\TestCase;
use Matrix\ArrayOperationHelper;

class ArrayOperationHelperTest extends TestCase
{
    public function test_with_invalid_rotation_throws_exception(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Rotation(2, 3);
    }
    /**
     * @dataProvider counterclockwiseSimpleDataProvider
     */
    public function test_rotate_simple_array_counterclockwise(Rotation $rotation, array $input, array $expected): void
    {
        $this->assertEquals($expected, ArrayOperationHelper::rotateSimple($input, $rotation));
    }
    /**
     * @dataProvider clockwiseSimpleDataProvider
     */
    public function test_rotate_simple_array_clockwise(Rotation $rotation, array $input, array $expected): void
    {
        $this->assertEquals($expected, ArrayOperationHelper::rotateSimple($input, $rotation));
    }
    /**
     * @dataProvider counterclockwiseHashMapDataProvider
     */
    public function test_rotate_hashmap_array_counterclockwise(Rotation $rotation, array $input, array $expected): void
    {
        $this->assertEquals($expected, ArrayOperationHelper::rotateHashMap($input, $rotation));
    }
    /**
     * @dataProvider clockwiseHashMapDataProvider
     */
    public function test_rotate_hashmap_array_clockwise(Rotation $rotation, array $input, array $expected): void
    {
        $this->assertEquals($expected, ArrayOperationHelper::rotateHashMap($input, $rotation));
    }

    public function clockwiseSimpleDataProvider(): array
    {
        return [
            [
                new Rotation(Rotation::DIRECTION_CLOCKWISE, 3),
                [1, 2, 3, 4, 5, 6, 7],
                [5, 6, 7, 1, 2, 3, 4],
            ],
            [
                new Rotation(Rotation::DIRECTION_COUNTERCLOCKWISE, -3),
                [1, 2, 3, 4, 5, 6, 7],
                [5, 6, 7, 1, 2, 3, 4],
            ],
            [
                new Rotation(Rotation::DIRECTION_CLOCKWISE, 9),
                [1, 2, 3, 4, 5, 6, 7],
                [6, 7, 1, 2, 3, 4, 5],
            ],
            [
                new Rotation(Rotation::DIRECTION_CLOCKWISE, 0),
                [1, 2, 3, 4, 5, 6, 7],
                [1, 2, 3, 4, 5, 6, 7],
            ],
        ];
    }

    public function counterclockwiseSimpleDataProvider(): array
    {
        return [
            [
                new Rotation(Rotation::DIRECTION_COUNTERCLOCKWISE, 3),
                [1, 2, 3, 4, 5, 6, 7],
                [4, 5, 6, 7, 1, 2, 3],
            ],
            [
                new Rotation(Rotation::DIRECTION_CLOCKWISE, -3),
                [1, 2, 3, 4, 5, 6, 7],
                [4, 5, 6, 7, 1, 2, 3],
            ],
            [
                new Rotation(Rotation::DIRECTION_COUNTERCLOCKWISE, 9),
                [1, 2, 3, 4, 5, 6, 7],
                [3, 4, 5, 6, 7, 1, 2],
            ],
            [
                new Rotation(Rotation::DIRECTION_COUNTERCLOCKWISE, 0),
                [1, 2, 3, 4, 5, 6, 7],
                [1, 2, 3, 4, 5, 6, 7],
            ],
        ];
    }

    public function clockwiseHashMapDataProvider(): array
    {
        return [
            [
                new Rotation(Rotation::DIRECTION_CLOCKWISE, 0),
                [
                    'one' => 1,
                    'two' => 2,
                    'three' => 3,
                    'four' => 4,
                    'five' => 5,
                    'six' => 6,
                    'seven' => 7,
                ],
                [
                    'one' => 1,
                    'two' => 2,
                    'three' => 3,
                    'four' => 4,
                    'five' => 5,
                    'six' => 6,
                    'seven' => 7,
                ],
            ],
            [
                new Rotation(Rotation::DIRECTION_CLOCKWISE, 4),
                [
                    'one' => 1,
                    'two' => 2,
                    'three' => 3,
                    'four' => 4,
                    'five' => 5,
                    'six' => 6,
                    'seven' => 7,
                ],
                [
                    'three' => 3,
                    'four' => 4,
                    'five' => 5,
                    'six' => 6,
                    'seven' => 7,
                    'one' => 1,
                    'two' => 2,
                ],
            ],
        ];
    }

    public function counterclockwiseHashMapDataProvider(): array
    {
        return [
            [
                new Rotation(Rotation::DIRECTION_COUNTERCLOCKWISE, 0),
                [
                    'one' => 1,
                    'two' => 2,
                    'three' => 3,
                    'four' => 4,
                    'five' => 5,
                    'six' => 6,
                    'seven' => 7,
                ],
                [
                    'one' => 1,
                    'two' => 2,
                    'three' => 3,
                    'four' => 4,
                    'five' => 5,
                    'six' => 6,
                    'seven' => 7,
                ],
            ],
            [
                new Rotation(Rotation::DIRECTION_COUNTERCLOCKWISE, 4),
                [
                    'one' => 1,
                    'two' => 2,
                    'three' => 3,
                    'four' => 4,
                    'five' => 5,
                    'six' => 6,
                    'seven' => 7,
                ],
                [
                    'five' => 5,
                    'six' => 6,
                    'seven' => 7,
                    'one' => 1,
                    'two' => 2,
                    'three' => 3,
                    'four' => 4,
                ],
            ],
        ];
    }
}
