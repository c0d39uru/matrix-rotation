<?php declare(strict_types = 1);

namespace Matrix;

class Rotation
{
    public const DIRECTION_CLOCKWISE = 0;
    public const DIRECTION_COUNTERCLOCKWISE = 1;

    private $direction;
    private $numberOfRotations;

    /**
     * @param $direction
     * @param $numberOfRotations
     * @throws \InvalidArgumentException
     */
    public function __construct(int $direction, int $numberOfRotations)
    {
        if ($direction !== self::DIRECTION_CLOCKWISE && $direction !== self::DIRECTION_COUNTERCLOCKWISE) {
            throw new \InvalidArgumentException('Bad $direction; it should be either ' . self::DIRECTION_CLOCKWISE . ' (clockwise) or ' . self::DIRECTION_COUNTERCLOCKWISE . ' (counterclockwise)');
        }

        $this->direction = $numberOfRotations >= 0
            ? $direction
            : self::getOppositeDirection($direction);

        $this->numberOfRotations = abs($numberOfRotations);
    }

    public function getDirection(): int
    {
        return $this->direction;
    }

    public function getNumberOfRotations(): int
    {
        return $this->numberOfRotations;
    }

    private static function getOppositeDirection(int $direction): int
    {
        if ($direction === self::DIRECTION_CLOCKWISE) {
            return self::DIRECTION_COUNTERCLOCKWISE;
        }

        return self::DIRECTION_CLOCKWISE;
    }
}