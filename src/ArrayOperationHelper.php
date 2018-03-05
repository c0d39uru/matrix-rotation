<?php declare(strict_types = 1);

namespace Matrix;

class ArrayOperationHelper
{
    public static function rotateSimple(array $data, Rotation $rotation): array
    {
        $numEffectiveRotation = $rotation->getNumberOfRotations() % \count($data);

        if (0 === $numEffectiveRotation) {
            return $data;
        }

        if (Rotation::DIRECTION_CLOCKWISE === $rotation->getDirection()) {
            return self::_rotate_simple_array_clockwise($data, $numEffectiveRotation);
        }

        return self::_rotate_simple_array_counterclockwise($data, $numEffectiveRotation);
    }

    public static function rotateHashMap(array $data, Rotation $rotation): array
    {
        return array_combine(
            self::rotateSimple(array_keys($data), $rotation),
            self::rotateSimple(array_values($data), $rotation)
        );
    }

    private static function _rotate_simple_array_clockwise(array $data, int $numEffectiveRotation): array
    {
        return \array_merge(
            \array_slice($data, -$numEffectiveRotation),
            \array_slice($data, 0, \count($data) - $numEffectiveRotation)
        );
    }

    private static function _rotate_simple_array_counterclockwise(array $data, int $numEffectiveRotation): array
    {
        return \array_merge(
            \array_slice($data, $numEffectiveRotation),
            \array_slice($data, 0, $numEffectiveRotation)
        );
    }
}